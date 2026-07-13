<?php

namespace App\Models;

use App\User;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable;

class Unit extends Model
{
    use GlobalSearchable;

    protected $fillable = ['property_id', 'number', 'size', 'type', 'no_of_bedrooms', 'no_of_bathrooms', 'no_of_livingrooms', 'no_of_kitchens', 'unit_description', 'estimated_rent', 'unit_status_id'];

    /**
     * The columns that should be ordered.
     *
     * @var array
     */
    protected $order = [
        'number' => 'desc',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($unit) {
            foreach ($unit->invoices as $invoice) {
                $invoice->delete();
            }
            foreach ($unit->leases as $lease) {
                $lease->delete();
            }
        });
    }

    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'number', 'name' => 'number', 'title' => 'Unit Number'],
            ['data' => 'size', 'name' => 'size', 'title' => 'Unit Size'],
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
            ['data' => 'type', 'name' => 'type', 'title' => 'Unit Type'],
            ['data' => 'no_of_bedrooms', 'name' => 'no_of_bedrooms', 'title' => 'No Of Bedrooms'],
            ['data' => 'no_of_bathrooms', 'name' => 'no_of_bathrooms', 'title' => 'No Of Bathrooms'],
        ];

        return json_encode($data);
    }

    public function attachUnits($units, $id, $module)
    {
        $status_model = new Status();

        $status_id = $status_model->getStatusID($this->getTable(), 'active');

        foreach ($units as $unit) {

            $array = ['property_id' => $id,
                'number' => $unit['number'],
                'size' => $unit['size'],
                'type' => $unit['type'],
                'estimated_rent' => $unit['estimated_rent'],
                'no_of_bedrooms' => isset($unit['no_of_bedrooms']) ? $unit['no_of_bedrooms'] : null,
                'no_of_bathrooms' => isset($unit['no_of_bathrooms']) ? $unit['no_of_bathrooms'] : null,
                'no_of_livingrooms' => isset($unit['no_of_livingrooms']) ? $unit['no_of_livingrooms'] : null,
                'unit_description' => isset($unit['unit_description']) ? $unit['unit_description'] : null,
                'no_of_kitchens' => isset($unit['no_of_kitchens']) ? $unit['no_of_kitchens'] : null
            ];
            $un = $this::where('number', $unit['number'])->where('property_id', $id)->first();

            if (isset($unit['id'])) {
                $this->findOrFail($unit['id'])->update($array);
            } else {
                $array['unit_status_id'] = $status_id;
                $this->create($array);
            }
        }

    }

    public function leases()
    {
        return $this->hasMany(Lease::class, 'unit_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'unit_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'unit_status_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function getActiveUnits($property_id)
    {
        return $this->where('property_id', $property_id)->whereHas('status', function ($q) {
            $q->where('status', 'active');
        })->get();
    }

    public function changeUnitStatus($unit_id, $status)
    {
        $unit = Unit::findOrFail($unit_id);
        $unit->update(['unit_status_id' => $status]);
    }

    public function getReportData($user)
    {
        $user_model = new User();

        $query = $this->with(['property'])->whereHas('status', function ($q) {
            $q->where('slug', 'active');
        });

        if (!in_array($user->role_id, $user_model->getSuperAdminRoleIds())) {
            $query = $query->whereHas('property.assigned_to', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        return $query;
    }

    public function getDataForUnitBarGraph($value, $request)
    {
        $start_date = isset($request['start_date']) ? $request['start_date'] : '';
        $end_date = isset($request['end_date']) ? $request['end_date'] : '';

        if (!$start_date && !$end_date) {

            $start_date = date("Y-m-d", strtotime("this year January 1st"));
            $end_date = date("Y-m-d", strtotime("this year December 31st"));

        }

        $current_user = Auth()->user();

        $status_model = new Status();

        $over_due_payment_model = new OverduePayment();

        $nav_data = [];

        $nav_data[0]['name'] = 'Collected';

        $nav_data[1]['name'] = 'Uncollected';

        $nav_data[2]['name'] = 'Vacant';

        $nav_data[3]['name'] = 'Combined';

        $nav_data[0]['colors'] = ['window.chartColors.green', 'window.chartColors.palegrey'];
        $nav_data[1]['colors'] = ['window.chartColors.red', 'window.chartColors.palegrey'];
        $nav_data[2]['colors'] = ['window.chartColors.grey', 'window.chartColors.palegrey'];
        $nav_data[3]['colors'] = ['window.chartColors.warmblue', 'window.chartColors.grey', 'window.chartColors.palegrey'];
        $nav_data[0]['x'] = ['Collected'];
        $nav_data[1]['x'] = ['Uncollected'];
        $nav_data[2]['x'] = ['Vacant'];
        $nav_data[3]['x'] = ['Collected', 'Uncollected', 'Vacant'];

        if ($value == 'unit_years') {

            $years = [];

            $start_year = date('Y', strtotime($start_date));
            $end_year = date('Y', strtotime($end_date));

            for ($year = $start_year; $year <= $end_year; $year++) {
                $years[] = (string)$year;
            }

            foreach ($years as $key => $year) {

                $nav_data[0]['label'][] = $year;
                $nav_data[1]['label'][] = $year;
                $nav_data[2]['label'][] = $year;
                $nav_data[3]['label'][] = $year;


                $due_paid_amount = $this->selectRaw('sum(invoices.total_amount) as value, YEAR(invoices.start_date) as label')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->whereRaw('YEAR(start_date) = ' . $year)
                    ->join('invoices', 'invoices.unit_id', '=', 'units.id')
                    ->groupBy('label')
                    ->orderBy('start_date', 'ASC')
                    ->first();

                $nav_data[0]['dataPoints'][$key] = !is_null($due_paid_amount) ? $due_paid_amount->value : 0;

                $overdue_unpaid_amount = $over_due_payment_model->selectRaw('sum(amount) as value, YEAR(created_at) as label')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->whereRaw('YEAR(created_at) =' . $year)
                    ->groupBy('label')
                    ->orderBy('created_at', 'ASC')
                    ->first();

                $nav_data[1]['dataPoints'][$key] = !is_null($overdue_unpaid_amount) ? $overdue_unpaid_amount->value : 0;

                $estimated_amount = $this->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                    !isset($request['property']) ?: $q->where('property_id', $request['property']);

                    $q->where('user_id', $current_user->id);

                })->sum('estimated_rent');

                $estimated_amount = !is_null($estimated_amount) ? $estimated_amount : 0;

                $due_paid_amount = !is_null($due_paid_amount) ? $due_paid_amount->value : 0;

                $nav_data[2]['dataPoints'][$key] = ($estimated_amount * 12) - $due_paid_amount;

                $nav_data[2]['dataPoints1'][$key] = ($estimated_amount * 12) - $due_paid_amount;

                $due_combined = $due_paid_amount;

                $nav_data[3]['dataPoints'][$key] = $due_combined;

                $overdue_unpaid_amount = !is_null($overdue_unpaid_amount) ? $overdue_unpaid_amount->value : 0;

                $overdue_combined = $overdue_unpaid_amount;

                $nav_data[3]['dataPoints1'][$key] = $overdue_combined;

            }
        } elseif ($value == 'unit_months') {
            $period = new \DatePeriod(
                (new \DateTime($start_date))->modify('first day of this month'),
                \DateInterval::createFromDateString('1 month'),
                (new \DateTime($end_date))->modify('first day of next month')
            );

            foreach ($period as $key => $dt) {

                $month = [
                    'month' => $dt->format("F"),
                    'year' => $dt->format("Y"),
                ];

                $nav_data[0]['label'][] = date('M', strtotime($month['month'])).' ('.$month['year'].')';
                $nav_data[1]['label'][] = date('M', strtotime($month['month'])).' ('.$month['year'].')';
                $nav_data[2]['label'][] = date('M', strtotime($month['month'])).' ('.$month['year'].')';
                $nav_data[3]['label'][] = date('M', strtotime($month['month'])).' ('.$month['year'].')';

                $due_paid_amount = $this->selectRaw('sum(invoices.total_amount) as value, MONTHNAME(invoices.start_date) as label')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->whereRaw("YEAR(start_date) ='" . $month['year'] . "'")
                    ->whereRaw("MONTHNAME(invoices.start_date) = '" . $month['month'] . "'")
                    ->join('invoices', 'invoices.unit_id', '=', 'units.id')
                    ->groupBy('label')
                    ->first();

                $nav_data[0]['dataPoints'][$key] = !is_null($due_paid_amount) ? $due_paid_amount->value : 0;

                $overdue_unpaid_amount = $over_due_payment_model->selectRaw('sum(amount) as value, MONTHNAME(created_at) as label')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->whereRaw("MONTHNAME(created_at) = '" . $month['month'] . "'")
                    ->whereRaw('YEAR(created_at) =' . $month['year'])
                    ->groupBy('label')
                    ->first();

                $nav_data[1]['dataPoints'][$key] = !is_null($overdue_unpaid_amount) ? $overdue_unpaid_amount->value : 0;

                $estimated_amount = $this->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                    !isset($request['property']) ?: $q->where('property_id', $request['property']);

                    $q->where('user_id', $current_user->id);

                })->sum('estimated_rent');

                $due_paid_amount = !is_null($due_paid_amount) ? $due_paid_amount->value : 0;

                $estimated_amount = !is_null($estimated_amount) ? $estimated_amount : 0;

                $nav_data[2]['dataPoints'][$key] = $estimated_amount - $due_paid_amount;

                $nav_data[2]['dataPoints1'][$key] = $estimated_amount - $due_paid_amount;

                $nav_data[3]['dataPoints'][$key] = $due_paid_amount;

                $overdue_unpaid_amount = !is_null($overdue_unpaid_amount) ? $overdue_unpaid_amount->value : 0;

                $nav_data[3]['dataPoints1'][$key] = $overdue_unpaid_amount;

            }

        } elseif ($value == 'unit_quarterly') {

            $quarters = getQuarters($start_date, $end_date);

            $invoice_model = new Invoice();

            foreach ($quarters as $key => $quarter) {
                $nav_data[0]['label'][$key] = $quarter->period;
                $nav_data[1]['label'][$key] = $quarter->period;
                $nav_data[2]['label'][$key] = $quarter->period;
                $nav_data[3]['label'][$key] = $quarter->period;

                $due_paid_amount = $invoice_model
                    ->whereHas('unit.property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->where('start_date', '>=', $quarter->period_start)
                    ->where('start_date', '<=', $quarter->period_end)
                    ->sum('total_amount');


                $nav_data[0]['dataPoints'][$key] = !is_null($due_paid_amount) ? $due_paid_amount : 0;

                $over_due_unpaid_amount = $over_due_payment_model
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->where('created_at', '>=', $quarter->period_start)
                    ->where('created_at', '<=', $quarter->period_end)
                    ->sum('amount');

                $nav_data[1]['dataPoints'][$key] = !is_null($over_due_unpaid_amount) ? $over_due_unpaid_amount : 0;

                $estimated_amount = $this->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                    !isset($request['property']) ?: $q->where('property_id', $request['property']);

                    $q->where('user_id', $current_user->id);

                })->sum('estimated_rent');

                $due_paid_amount = !is_null($due_paid_amount) ? $due_paid_amount : 0;

                $estimated_amount = !is_null($estimated_amount) ? $estimated_amount : 0;

                $nav_data[2]['dataPoints'][$key] = $estimated_amount - $due_paid_amount;

                $nav_data[2]['dataPoints1'][$key] = $estimated_amount - $due_paid_amount;

                $nav_data[3]['dataPoints'][$key] = $due_paid_amount;

                $overdue_unpaid_amount = !is_null($over_due_unpaid_amount) ? $over_due_unpaid_amount : 0;

                $nav_data[3]['dataPoints1'][$key] = $overdue_unpaid_amount;
            }
        }
        elseif ($value == 'unit_semi_annually') {

            $quarters = getSemiAnnually($start_date, $end_date);

            $invoice_model = new Invoice();

            foreach ($quarters as $key => $quarter) {

                $nav_data[0]['label'][$key] = $quarter->period;
                $nav_data[1]['label'][$key] = $quarter->period;
                $nav_data[2]['label'][$key] = $quarter->period;
                $nav_data[3]['label'][$key] = $quarter->period;

                $due_paid_amount = $invoice_model
                    ->whereHas('unit.property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->where('start_date', '>=', $quarter->period_start)
                    ->where('start_date', '<=', $quarter->period_end)
                    ->sum('total_amount');


                $nav_data[0]['dataPoints'][$key] = !is_null($due_paid_amount) ? $due_paid_amount : 0;

                $over_due_unpaid_amount = $over_due_payment_model
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->where('created_at', '>=', $quarter->period_start)
                    ->where('created_at', '<=', $quarter->period_end)
                    ->sum('amount');

                $nav_data[1]['dataPoints'][$key] = !is_null($over_due_unpaid_amount) ? $over_due_unpaid_amount : 0;

                $estimated_amount = $this->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                    !isset($request['property']) ?: $q->where('property_id', $request['property']);

                    $q->where('user_id', $current_user->id);

                })->sum('estimated_rent');

                $due_paid_amount = !is_null($due_paid_amount) ? $due_paid_amount : 0;

                $estimated_amount = !is_null($estimated_amount) ? $estimated_amount : 0;

                $nav_data[2]['dataPoints'][$key] = $estimated_amount - $due_paid_amount;

                $nav_data[2]['dataPoints1'][$key] = $estimated_amount - $due_paid_amount;

                $nav_data[3]['dataPoints'][$key] = $due_paid_amount;

                $overdue_unpaid_amount = !is_null($over_due_unpaid_amount) ? $over_due_unpaid_amount : 0;

                $nav_data[3]['dataPoints1'][$key] = $overdue_unpaid_amount;
            }
        } else {

            $weeks = new \DatePeriod(
                new \DateTime($start_date),
                new \DateInterval('P1W'),
                new \DateTime($end_date)
            );
            $current_month = '';
            $current_week = 1;
            foreach ($weeks as $key => $week) {

                if (!$key) {
                    continue;
                }

                $key = $key - 1;

                $week = [
                    'week' => $week->format('W'),
                    'year' => $week->format('Y'),
                    'month' => $week->format('M'),
                ];


                if ($week['month'] !== $current_month) {
                    $current_month = $week['month'];
                    $current_week = 1;
                }

                $label = $week['month'] . ' w' . sprintf('%02d', $current_week);
                $current_week++;
                $nav_data[0]['label'][$key] = $label;
                $nav_data[1]['label'][$key] = $label;
                $nav_data[2]['label'][$key] = $label;
                $nav_data[3]['label'][$key] = $label;

                // $nav_data[0]['label'][$key] = $week['month'] . ' w' . $week['week'];
                // $nav_data[1]['label'][$key] = $week['month'] . ' w' . $week['week'];
                // $nav_data[2]['label'][$key] = $week['month'] . ' w' . $week['week'];
                // $nav_data[3]['label'][$key] = $week['month'] . ' w' . $week['week'];

                $due_paid_amount = $this->selectRaw('sum(invoices.total_amount) as value, WEEK(invoices.start_date) as label')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->whereRaw('WEEK(invoices.start_date) =' . $week['week'])
                    ->whereRaw('YEAR(invoices.start_date) =' . $week['year'])
                    ->join('invoices', 'invoices.unit_id', '=', 'units.id')
                    ->groupBy('label')
                    ->first();

                $nav_data[0]['dataPoints'][$key] = !is_null($due_paid_amount) ? $due_paid_amount->value : 0;

                $over_due_unpaid_amount = $over_due_payment_model->selectRaw('sum(amount) as value, WEEK(created_at) as label')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->whereRaw('WEEK(created_at) =' . $week['week'])
                    ->whereRaw('YEAR(created_at) =' . $week['year'])
                    ->groupBy('label')
                    ->first();

                $nav_data[1]['dataPoints'][$key] = !is_null($over_due_unpaid_amount) ? $over_due_unpaid_amount->value : 0;

                $estimated_amount = $this->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                    !isset($request['property']) ?: $q->where('property_id', $request['property']);

                    $q->where('user_id', $current_user->id);

                })->sum('estimated_rent');

                $due_paid_amount = !is_null($due_paid_amount) ? $due_paid_amount->value : 0;

                $estimated_amount = !is_null($estimated_amount) ? $estimated_amount : 0;

                $nav_data[2]['dataPoints'][$key] = $estimated_amount - $due_paid_amount;

                $nav_data[2]['dataPoints1'][$key] = $estimated_amount - $due_paid_amount;

                $nav_data[3]['dataPoints'][$key] = $due_paid_amount;

                $overdue_unpaid_amount = !is_null($over_due_unpaid_amount) ? $over_due_unpaid_amount->value : 0;

                $nav_data[3]['dataPoints1'][$key] = $overdue_unpaid_amount;
            }
        }

        $height = '350';
        $width = '550';
        $class = 'set-min-height';

        $select_data = [
            [
                'tab_title' => 'Weekly',
                'tab_value' => 'unit_week'
            ],
            [
                'tab_title' => 'Monthly',
                'tab_value' => 'unit_months'
            ],
            [
                'tab_title' => 'Quarterly',
                'tab_value' => 'unit_quarterly'
            ],
            [
                'tab_title' => 'Semi Annually',
                'tab_value' => 'unit_semi_annually'
            ],
            [
                'tab_title' => 'Annually',
                'tab_value' => 'unit_years',
            ]
        ];

        $route_for_search = 'properties-get-graph-data';

        return json_encode(compact('height', 'width', 'nav_data', 'class', 'select_data', 'route_for_search'));
    }

    private $weekDays = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    ];

    function getDateOfWeekDay($day)
    {
        $dayNumber = array_search($day, $this->weekDays);
        $currentDayNumber = date('w', strtotime('today'));

        if ($dayNumber > $currentDayNumber) {
            return date('Y-m-d', strtotime($day));
        } else {
            return date('Y-m-d', strtotime($day) - 604800);
        }

    }

    public function getDataForVacancyBarometer($request)
    {
        $user = Auth()->user();

        $total_units = $this;

        if (!in_array($user->role_id, $user->getSuperAdminRoleIds())) {
            $total_units = $total_units->whereHas('property.assigned_to', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        if (isset($request['property'])) {

            $total_units = $total_units->where('property_id', $request['property']);
        }

         if(isset($request['start_date']) && isset($request['end_date']))
         {
            $total_units->whereBetween('created_at',[$request['start_date'], $request['end_date']]);
         }

        $data['value'] = $total_units->count();
        $data['value1'] = $total_units->whereHas('status', function ($q) {
            $q->where('slug', 'active');
        })->count();

        return json_encode($data);
    }
}
