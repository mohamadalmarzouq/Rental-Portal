<?php

namespace App\Models;

use App\User;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Invoice extends Model implements HasMedia
{
    use EloquentJoin, HasMediaTrait;

    protected $fillable = ['type_id', 'property_id', 'unit_id', 'start_date', 'end_date', 'total_amount',
        'invoice_status_id', 'lease_id', 'description', 'payment_method_id', 'tenant_id', 'comment', 'comment_added_by', 'deposit'];

    protected $appends = ['duration', 'invoice_status', 'amount', 'lease_amount', 'over_due_amount', 'rent_month', 'comment_name', 'over_due_days', 'invoice_property', 'invoice_unit'];

    private $prevent_mutator = false;

    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'id', 'name' => 'id', 'title' => 'Invoice ID'],
            ['data' => 'type.name', 'name' => 'type.name', 'title' => 'Type'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description', 'width' => '50px'],
            ['data' => 'invoice_property', 'name' => 'invoice_property', 'title' => 'Property Name'],
            ['data' => 'invoice_unit', 'name' => 'invoice_unit', 'title' => 'Unit'],
            // ['data' => 'invoice_property', 'name' => 'invoice_property', 'title' => 'Prop'],
            //   ['data' => 'invoice_extras', 'name' => 'invoice_extras.property.name', 'title' => 'Invoice Extra'],
            // ['data' => 'amount', 'name' => 'amount','title' => 'Total Amount' ,'searchable' => 'false'],
            //  ['data' => 'payment_method.name', 'name' => 'payment_method.name', 'title' => 'Payment Method'],
            ['data' => 'invoice_status', 'name' => 'invoice_status', 'searchable' => 'false'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false'],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false]
        ];

        return json_encode($data);
    }
    public function getDescriptionAttribute($value)
    {
        return strlen($value) > 6 ? substr($value, 0, 6) . '...' : $value;
    }

    public function getExpenseColumnsForDataTable()
    {
        $data = [
            ['data' => 'id', 'name' => 'id', 'title' => 'Invoice ID'],
            ['data' => 'type.name', 'name' => 'type.name', 'title' => 'Type'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description', 'width' => '50px'],
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
            //    ['data' => 'unit.number', 'name' => 'unit.number', 'title' => 'Unit'],
            //   ['data' => 'tenant.name', 'name' => 'tenant.name', 'title' => 'Tenant Name'],
            // ['data' => 'amount', 'name' => 'amount','title' => 'Total Amount' , 'searchable' => 'false'],
            //  ['data' => 'payment_method.name', 'name' => 'payment_method.name', 'title' => 'Payment Method'],
            ['data' => 'invoice_status', 'name' => 'invoice_status', 'searchable' => 'false'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false'],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false]
        ];

        return json_encode($data);
    }


    public function orderArray()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'order' => true],
            ['data' => 'type.name', 'name' => 'type.name', 'order' => true, 'relationship' => ['model' => 'type', 'column_name' => 'name']],
            ['data' => 'description', 'name' => 'description', 'order' => true],
            ['data' => 'property_id', 'name' => 'property_id', 'order' => true],
            ['data' => 'unit_id', 'name' => 'unit_id', 'order' => true],
            ['data' => 'tenant_id', 'name' => 'tenant_id', 'order' => true],
            ['data' => 'total_amount', 'name' => 'total_amount', 'order' => true],
            ['data' => 'payment_method.name', 'name' => 'payment_method.name', 'order' => true, 'relationship' => ['model' => 'payment_method', 'column_name' => 'name']],
            ['data' => 'invoice_status_id', 'name' => 'invoice_status_id', 'order' => true],
            ['data' => 'action', 'name' => 'Action', 'order' => false],
            ['name' => 'created_at', 'order' => false]
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($invoice) {
            foreach ($invoice->notifications as $notification) {
                $notification->delete();
            }
        });
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'ref_id')->where('module', $this->getTable());
    }

    public function getLeaseAmountAttribute()
    {
        $query = $this->whereHas('lease')->first();

        return $query ? addCommaForNumeric($query->lease->amount_payable) : '';
    }

    public function getOverDueAmountAttribute()
    {
        $query = $this->whereHas('lease')->first();

        return $query ? addCommaForNumeric($query->monthly_rent) : '';
    }

    public function getOverDueDaysAttribute()
    {
        $now = time();

        $your_date = strtotime($this->end_date);

        $datediff = $now - $your_date;

        return round($datediff / (60 * 60 * 24));
    }

    public function getCommentNameAttribute()
    {
        return $this->comment_add_by ? $this->comment . ' (added by ' . $this->comment_add_by->name . ')' : '';
    }

    public function getRentMonthAttribute()
    {
        return date('M', strtotime($this->end_date));
    }

    public function orderingColumn()
    {
        return json_encode([['10', 'desc']]);
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function comment_add_by()
    {
        return $this->belongsTo(User::class, 'comment_added_by');
    }

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function getInvoicePropertyAttribute()
    {
        $property_array = [];
        if ($this->property) {
            array_push($property_array, $this->property->name);
        } else {
            $invoiceExtra = InvoiceExtra::with('property')->where('invoice_id',$this->id)->get()->pluck('property')->toArray();
            $property_array = collect($invoiceExtra)->pluck('name')->toArray();
        }
        $property_name = implode(',',$property_array);
        return $property_name;

    }

    public function getInvoiceUnitAttribute()
    {
        $unit_array = [];
        if ($this->unit) {
            array_push($unit_array, $this->unit->number);
        } else {
            $invoiceExtra = InvoiceExtra::with('unit')->where('invoice_id',$this->id)->get()->pluck('unit')->toArray();
            $unit_array = collect($invoiceExtra)->pluck('number')->toArray();
        }
        $unit_name = implode(',',$unit_array);
        return $unit_name;

    }

    public function invoice_extras()
    {
        return $this->hasMany(InvoiceExtra::class, 'invoice_id')->with(['property', 'unit', 'lease', 'tenant']);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'invoice_status_id')->where('module', $this->getTable());
    }

    public function getAmountAttribute()
    {
        return addCommaForNumeric($this->total_amount);
    }

    public function getInvoiceStatusAttribute()
    {
        $status = $this->status->slug;

        $status_name = $this->status->status;

        return View::make('panel.includes.status_mutator', compact('status', 'status_name'))->render();
    }

    public function getDurationAttribute()
    {
        return date('F jS, Y', strtotime($this->start_date)) . ' ' . date('F jS, Y', strtotime($this->end_date));
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function searchAjaxListing($request)
    {
        $current_user = Auth()->user();

        $query = $this->with(['type', 'property', 'unit', 'tenant', 'payment_method','invoice_extras']);


        if (isset($request['type'])) {

            $type = $request['type'];

            $query = $query->where('type_id', $type);
        }
       /*  if (isset($request['search'])) {

            $search = $request['search'];

            $query = $query->where('total_amount', $search);
        } */

        if (isset($request['property'])) {

            $property = $request['property'];

            $query = $query->where('property_id', $property);
        }

        if (isset($request['status'])) {

            $status = $request['status'];

            $query = $query->where('invoice_status_id', $status);
        }

        if (isset($request['method'])) {

            $method = $request['method'];

            $query = $query->where('payment_method_id', $method);
        }

        if (isset($request['date_start'])) {

            $date_start = $request['date_start'];

            $query = $query->where('start_date', date('Y-m-d', strtotime($date_start)));
        }

        if (isset($request['date_end'])) {

            $date_end = $request['date_end'];

            $query = $query->where('end_date', date('Y-m-d', strtotime($date_end)));
        }

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
            $query = $query->whereHas('property.assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            })->orWhereHas('invoice_extras' , function ($query) use ($current_user) {
                $query->whereHas('property.assigned_to', function ($q) use ($current_user) {
                    $q->where('user_id', $current_user->id);
                });
            });
        }

        return $query;
    }

    public function getColumnsForReportDataTable()
    {
        $data = [
            ['data' => 'id', 'name' => 'id', 'title' => 'Invoice ID'],
            ['data' => 'type.name', 'name' => 'type.name', 'title' => 'Type'],
            ['data' => 'tenant.name', 'name' => 'tenant.name', 'title' => 'Name'],
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
            ['data' => 'unit.number', 'name' => 'unit.number', 'title' => 'Unit'],
            ['data' => 'duration', 'name' => 'duration', 'title' => 'Invoice Duration', 'searchable' => 'false'],
            ['data' => 'amount', 'name' => 'amount', 'searchable' => 'false', 'title' => 'Amount'],
            ['data' => 'invoice_status', 'name' => 'invoice_status', 'searchable' => 'false', 'title' => 'Invoice Status'],
        ];

        return json_encode($data);
    }

    public function transactionLogs($request)
    {
        return $this->with(['type', 'property', 'unit', 'tenant', 'payment_method'])->where('lease_id', $request['lease_id']);
    }

    public function viewPaymentHistory($request)
    {
        return $this->with(['type', 'property', 'unit', 'tenant', 'payment_method'])->where('tenant_id', $request['tenant_id']);
    }

    public function widgetData()
    {
        $widget_array['revenues']['total'] = $this->ajaxListing()->whereHas('type', function ($q) {
            $q->where('slug', 'revenue')->where('module', $this->getTable());
        })->count();

        $widget_array['revenues']['pending'] = $this->ajaxListing()->whereHas('type', function ($q) {
            $q->where('slug', 'revenue')->where('module', $this->getTable());
        })->whereHas('status', function ($q) {
            $q->where('slug', 'pending')->where('module', $this->getTable());
        })->count();

        $widget_array['revenues']['approved'] = $this->ajaxListing()->whereHas('type', function ($q) {
            $q->where('slug', 'revenue')->where('module', $this->getTable());
        })->whereHas('status', function ($q) {
            $q->where('slug', '!=', 'pending')->where('module', $this->getTable());
        })->count();


        $widget_array['expenses']['total'] = $this->ajaxListing()->whereHas('type', function ($q) {
            $q->where('slug', 'expense')->where('module', $this->getTable());
        })->count();

        $widget_array['expenses']['pending'] = $this->ajaxListing()->whereHas('type', function ($q) {
            $q->where('slug', 'expense')->where('module', $this->getTable());
        })->whereHas('status', function ($q) {
            $q->where('slug', 'pending')->where('module', $this->getTable());
        })->count();

        $widget_array['expenses']['approved'] = $this->ajaxListing()->whereHas('type', function ($q) {
            $q->where('slug', 'expense')->where('module', $this->getTable());
        })->whereHas('status', function ($q) {
            $q->where('slug', '!=', 'pending')->where('module', $this->getTable());
        })->count();

        return $widget_array;
    }

    public function ajaxListing()
    {
        $current_user = Auth()->user();

        $query = $this->with(['type', 'property', 'unit', 'tenant', 'payment_method']);

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
        /*     $query = $query->whereHas('property.assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            })->orWhereHas('invoice_extras' , function ($query) use ($current_user) {
                $query->whereHas('property.assigned_to', function ($q) use ($current_user) {
                    $q->where('user_id', $current_user->id);
                });
            }); */

            $query = $query->where(function ($query) use ($current_user) {
                $query->whereHas('property.assigned_to', function ($q) use ($current_user) {
                    $q->where('user_id', $current_user->id);
                })->orWhereHas('invoice_extras', function ($query) use ($current_user) {
                    $query->whereHas('property.assigned_to', function ($q) use ($current_user) {
                        $q->where('user_id', $current_user->id);
                    });
                });
            });
        }

        return $query;
    }

    public function allPaidInvoices()
    {
        $current_user = Auth()->user();

        $query = $this->with(['type', 'property', 'unit', 'tenant', 'payment_method'])->whereHas('status', function ($q) {
            $q->where('slug', 'approved');
        });

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {

            $query = $query->whereHas('property.assigned_to', function ($q) use ($current_user) {

                $q->where('user_id', $current_user->id);
            });
        }

        return $query;
    }


    public function getUnpaidInvoices($user)
    {
        $user_model = new User();

        $query = $this->with(['type', 'property', 'unit', 'tenant'])->whereHas('status', function ($q) {
            $q->where('slug', 'pending');
        });

        if (!in_array($user->role_id, $user_model->getSuperAdminRoleIds())) {

            $query = $query->whereHas('property.assigned_to', function ($q) use ($user) {

                $q->where('user_id', $user->id);
            });
        }

        return $query;
    }

    public function canceledInvoices()
    {
        $current_user = Auth()->user();

        $query = $this->with(['type', 'property', 'unit', 'tenant'])->whereHas('status', function ($q) {
            $q->where('slug', 'cancelled');
        });

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {

            $query = $query->whereHas('property.assigned_to', function ($q) use ($current_user) {

                $q->where('user_id', $current_user->id);
            });
        }

        return $query;
    }

    public function plotGraphWidgetData($search_year)
    {
        $year = $search_year ? $search_year : 'YEAR(CURRENT_DATE)';

        $current_user = Auth()->user();

        $this->prevent_mutator = true;

        $status_model = new Status();

        $unpaid_invoice_status_id = $status_model->getStatusID($this->getTable(), 'pending');

        $all_months = Month::get();

        $data = [];

        foreach ($all_months as $key => $month) {

            $query = $this->selectRaw('sum(total_amount) as value, MONTHNAME(end_date) as label, invoice_status_id')->where('invoice_status_id', $unpaid_invoice_status_id)
                ->whereHas('property.assigned_to', function ($q) use ($current_user) {
                    $q->where('user_id', $current_user->id);
                })
                ->whereRaw('YEAR(end_date) = ' . $year)
                ->whereRaw("MONTHNAME(end_date) = '" . $month->month . "'")
                ->where('end_date', '<', date('Y-m-d'))
                ->groupBy('label')
                ->orderBy('end_date', 'ASC')
                ->first();

            $data[$key]['label'] = $month->month;
            $data[$key]['value'] = !is_null($query) ? $query->value : 0;

        }

        $total_value = $this->where('invoice_status_id', $unpaid_invoice_status_id)
            ->whereHas('property.assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            })
            ->whereRaw('YEAR(end_date) = ' . $year)
            ->where('end_date', '<', date('Y-m-d'))
            ->sum('total_amount');

        $nav_data = $this->selectRaw('YEAR(end_date) as value, invoice_status_id')->where('invoice_status_id', $unpaid_invoice_status_id)
            ->whereHas('property.assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            })->groupBy('value')
            ->get();

        $label = 'Total Amount';

        $header = 'OVER DUE PAYMENT';

        $selected_nav_value = $search_year ? $search_year : date('Y');

        return json_encode(compact('data', 'label', 'total_value', 'header', 'nav_data', 'selected_nav_value'));
    }

    public function getDataForRevenueBarGraph($value, $request)
    {
        $start_date = isset($request['start_date']) ? $request['start_date'] : '';
        $end_date = isset($request['end_date']) ? $request['end_date'] : '';

        if (!$start_date && !$end_date) {

            $start_date = date("Y-m-d", strtotime("this year January 1st"));
            $end_date = date("Y-m-d", strtotime("this year December 31st"));

        }

        $current_user = Auth()->user();

        $status_model = new Status();

        $paid_status_id = $status_model->getStatusID($this->getTable(), 'approved');

        $type_model = new Type();
        $revenue_type_id = $type_model->getTypeId($this->getTable(), 'revenue');
        $expense_type_id = $type_model->getTypeId($this->getTable(), 'expense');

        $total_expense = 0;
        $total_revenue = 0;

        $graph_data['colors'] = ['window.chartColors.greenblue', 'window.chartColors.lipstick'];

        $graph_data['x'] = [tn('Revenue'), tn('Expense')];
        if ($value == 'unit_years') {

            $years = [];

            $start_year = date('Y', strtotime($start_date));
            $end_year = date('Y', strtotime($end_date));

            for ($year = $start_year; $year <= $end_year; $year++) {
                $years[] = (string)$year;
            }

            foreach ($years as $key => $year) {

                $graph_data['label'][] = $year;

                $revenue = $this->selectRaw('sum(total_amount) as value, YEAR(end_date) as label, invoice_status_id')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->where('type_id', $revenue_type_id)
                    ->whereRaw("YEAR(end_date) = '" . $year . "'")
                    ->where('invoice_status_id', $paid_status_id)
                    ->groupBy('label')
                    ->orderBy('end_date', 'ASC')
                    ->first();

                $revenue_amount = !is_null($revenue) ? $revenue->value : 0;

                $graph_data['dataPoints'][$key] = $revenue_amount;
                $total_revenue += $revenue_amount;

                $expense = $this->selectRaw('sum(total_amount) as value, YEAR(end_date) as label, invoice_status_id')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->where('type_id', $expense_type_id)
                    ->where('invoice_status_id', $paid_status_id)
                    ->whereRaw("YEAR(end_date) = '" . $year . "'")
                    ->groupBy('label')
                    ->orderBy('end_date', 'ASC')
                    ->first();

                $expense_amount = !is_null($expense) ? $expense->value : 0;

                $graph_data['dataPoints1'][$key] = $expense_amount;
                $total_expense += $expense_amount;
            }

        } else {

            $period = new \DatePeriod(
                (new \DateTime($start_date))->modify('first day of this month'),
                \DateInterval::createFromDateString('1 month'),
                (new \DateTime($end_date))->modify('first day of next month')
            );

            foreach ($period as $key => $dt) {

                $month = [
                    'month_name' => $dt->format("M"),
                    'month' => $dt->format("F"),
                    'year' => $dt->format("Y"),
                ];

                $graph_data['label'][] = $month['month_name'];

                $revenue = $this->selectRaw('sum(total_amount) as value, MONTHNAME(end_date) as label, invoice_status_id')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->where('type_id', $revenue_type_id)
                    ->where('invoice_status_id', $paid_status_id)
                    ->whereRaw("YEAR(end_date) = '" . $month['year'] . "'")
                    ->whereRaw("MONTHNAME(end_date) = '" . $month['month'] . "'")
                    ->groupBy('label')
                    ->orderBy('end_date', 'ASC')
                    ->first();

                $revenue_amount = !is_null($revenue) ? $revenue->value : 0;

                $graph_data['dataPoints'][$key] = $revenue_amount;
                $total_revenue += $revenue_amount;

                $expense = $this->selectRaw('sum(total_amount) as value, MONTHNAME(end_date) as label, invoice_status_id')
                    ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                        !isset($request['property']) ?: $q->where('property_id', $request['property']);

                        $q->where('user_id', $current_user->id);

                    })->where('type_id', $expense_type_id)
                    ->where('invoice_status_id', $paid_status_id)
                    ->whereRaw("YEAR(end_date) = '" . $month['year'] . "'")
                    ->whereRaw("MONTHNAME(end_date) = '" . $month['month'] . "'")
                    ->groupBy('label')
                    ->orderBy('end_date', 'ASC')
                    ->first();

                $expense_amount = !is_null($expense) ? $expense->value : 0;

                $graph_data['dataPoints1'][$key] = $expense_amount;
                $total_expense += $expense_amount;

            }


        }

        $select_data = [
            [
                'tab_title' => 'Monthly',
                'tab_value' => 'invoice_months'
            ],
            [
                'tab_title' => 'Yearly',
                'tab_value' => 'invoice_years',
            ]
        ];

        $route_for_search = 'invoices-revenue-graph-data';
        $final_data = compact('graph_data', 'route_for_search', 'select_data');


        return json_encode($final_data);
    }

    public function getColumnsForOverDueAmountDataTable()
    {
        $data = [
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            ['data' => 'tenant.name', 'name' => 'tenant.name', 'title' => 'Tenant Name'],
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
            ['data' => 'unit.number', 'name' => 'unit.number', 'title' => 'Unit'],
//            ['data' => 'type.name', 'name' => 'type.name', 'title' => 'Type'],
            ['data' => 'over_due_amount', 'name' => 'over_due_amount', 'title' => 'Overdue Amount', 'searchable' => 'false'],
//            ['data' => 'payment_method.name', 'name' => 'payment_method.name', 'title' => 'Payment Method'],
            ['data' => 'lease.frequency.name', 'name' => 'lease.frequency.name', 'title' => 'Frequency'],
            ['data' => 'lease.month_rent', 'name' => 'lease.month_rent', 'title' => 'Monthly Rent', 'searchable' => 'false'],
            ['data' => 'comment', 'name' => 'comment', 'searchable' => 'false'],
        ];

        return json_encode($data);
    }

    public function getColumnsForOutStandingBalancesDataTable()
    {
        $data = [
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
            ['data' => 'unit.number', 'name' => 'unit.number', 'title' => 'Unit'],
            ['data' => 'amount', 'name' => 'amount', 'title' => 'Amount', 'searchable' => 'false'],
            ['data' => 'over_due_days', 'name' => 'over_due_days', 'title' => 'Days overdue', 'searchable' => 'false'],
            ['data' => 'comment', 'name' => 'comment', 'title' => "Comment"],
            //['data' => 'comment', 'name' => 'comment',"visible"=>"false"],
        ];

        return json_encode($data);
    }

    public function overDueInvoices($request = '')
    {
        $current_user = Auth()->user();
        $overdue_date = date("Y-m-d", strtotime(date('Y-m') . "-" . $current_user->due_date . ' + ' . $current_user->grace_period . ' days'));
        $previous_date = date('Y-m-d', strtotime(date('Y-m-d') . ' - ' . $current_user->overdue_days . ' days'));

        $query = $this->with(['type', 'property', 'unit', 'tenant', 'payment_method', 'lease.frequency'])
            ->whereHas('status', function ($q) {
                //$q->where('slug', 'un-paid');
            });
//->where('start_date', '>', $overdue_date)
        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {

            $query = $query->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                !isset($request['property']) ?: $q->where('property_id', $request['property']);

                $q->where('user_id', $current_user->id);
            })->whereHas('lease');
        }

        return $query;
    }

    public function invoiceStatus()
    {
        $status_model = new Status();

        $current_user = Auth()->user();

        if (!in_array($current_user->role_id, $current_user->getLandLordRoleIds())) {

            return $status_model->getStatusID($this->getTable(), 'pending');

        }

        return $status_model->getStatusID($this->getTable(), 'approved');
    }

    public function sendInvoiceByEmail($invoice_id)
    {
        $data = $this->findOrFail($invoice_id);

        $template = 'mail.invoice';

        Mail::send($template, compact('data'), function ($message) use ($data) {
            $message->to($data->tenant->email)->subject($data->property->name);
        });
    }

    public function getDataForExpenseBarGraph($request)
    {
        $start_date = isset($request['start_date']) ? $request['start_date'] : '';
        $end_date = isset($request['end_date']) ? $request['end_date'] : '';

        if (!$start_date && !$end_date) {

            $start_date = date("Y-m-d", strtotime("this year January 1st"));
            $end_date = date("Y-m-d", strtotime("this year December 31st"));

        }

        $current_user = Auth()->user();

        $all_months = Month::get();

        $status_model = new Status();

        $paid_status_id = $status_model->getStatusID($this->getTable(), 'approved');

        $expense_type_id = (new Type())->getTypeId($this->getTable(), 'expense');

        $graph_data['colors'] = [
            'window.chartColors.palegrey',
            'window.chartColors.white',
            'window.chartColors.white',
            'window.chartColors.lipstick'
        ];

        $graph_data['x'] = tn('Expense');

        $period = new \DatePeriod(
            (new \DateTime($start_date))->modify('first day of this month'),
            \DateInterval::createFromDateString('1 month'),
            (new \DateTime($end_date))->modify('first day of next month')
        );

        foreach ($period as $key => $dt) {

            $month = [
                'month_name' => $dt->format("M"),
                'month' => $dt->format("F"),
                'year' => $dt->format("Y"),
            ];

            $graph_data['label'][] = $month['month_name'];
            $expense = $this->selectRaw('sum(total_amount) as value, MONTHNAME(end_date) as label, invoice_status_id')
                ->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                    !isset($request['property']) ?: $q->where('property_id', $request['property']);

                    $q->where('user_id', $current_user->id);

                })->where('type_id', $expense_type_id)
                ->where('invoice_status_id', $paid_status_id)
                ->whereRaw("YEAR(end_date) = '" . $month['year'] . "'")
                ->whereRaw("MONTHNAME(end_date) = '" . $month['month'] . "'")
                ->groupBy('label')
                ->orderBy('end_date', 'ASC')
                ->first();

            $graph_data['dataPoints'][$key] = !is_null($expense) ? $expense->value : 0;

        }

        $route_for_search = 'invoices-expense-graph-data';

        $final_data = compact('graph_data', 'route_for_search');

        return json_encode($final_data);
    }

    public function getWaivedAmount($tenant_id)
    {
        $waived_amount = Lease::where('tenant_id', $tenant_id)->sum('waived_amount');
        $advance_payments = Lease::where('tenant_id',$tenant_id)->sum('advance_payment');
        $overdue_amount = OverduePayment::where('tenant_id', $tenant_id)->sum('amount');
        $deposit = Lease::where('tenant_id',$tenant_id)->sum('deposit');
        $tenant = Tenant::find($tenant_id);
        $tent_mail = $tenant->email;
        // $active_status_id = Status::where('module','tenants')->first()->id;
        $tent_status = $tenant->status;

        /* if($tent_status->slug == 'in-active')
        {

        } */
        $status = $tent_status->slug;
        return ['waived_amount' => $waived_amount, 'overdue_amount' => $overdue_amount,'advance_payments'=>$advance_payments,'deposit'=>$deposit,'tenant_email'=>$tent_mail,'status'=>$status];

    }
}
