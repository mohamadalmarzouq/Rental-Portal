<?php

namespace App\Models;

use App\User;
use DateTime;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable;

class Lease extends Model
{
    use GlobalSearchable, EloquentJoin;

    protected $fillable = ['property_id', 'type_id', 'lease_status_id',
        'tenant_id', 'frequency_id', 'amount_payable', 'start_date', 'end_date',
        'description', 'unit_id', 'enable_email', 'enable_sms', 'rental', 'monthly_rent',
        "residence_type",
        "marriage_status",
        "unit_id",
        "attachments",
        'due_date',
        'advance_payment', 'waived_amount', 'deposit','attachment_name'];

    protected $appends = ['lease_status', 'lease_payable', 'pending_amount', 'invoice_status', 'month_rent', 'lease_name', 'lease_rent'];

    /**
     * The columns that should be ordered.
     *
     * @var array
     */
    protected $order = [
        'lease_name' => 'desc',
    ];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    protected $search = [
        'lease_name'
    ];

    /**
     * The columns that should be displayed.
     *
     * @var array
     */
    protected $only = [
        'lease_name', 'id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($lease) {
            foreach ($lease->invoices as $invoice) {
                $invoice->delete();
            }
            foreach ($lease->overDuePayments as $overDuePayment) {
                $overDuePayment->delete();
            }
        });
    }

    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            ['data' => 'tenant.name', 'name' => 'tenant.name', 'title' => 'Tenant Name'],
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
            ['data' => 'unit.number', 'name' => 'unit.number', 'title' => 'Unit'],
            ['data' => 'type.name', 'name' => 'type.name', 'title' => 'Type'],
            ['data' => 'pending_amount', 'name' => 'pending_amount', 'title' => 'Monthly Rent', 'searchable' => 'false'],
            ['data' => 'frequency.name', 'name' => 'frequency.name', 'title' => 'Frequency'],
            // ['data' => 'month_rent', 'name' => 'month_rent', 'title' => 'Monthly Rent', 'searchable' => 'false'],
            ['data' => 'lease_status', 'name' => 'lease_status', 'title' => 'Lease Status', 'searchable' => 'false'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false'],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false],
            ['data' => 'monthly_rent', 'name' => 'monthly_rent', 'visible' => false],
        ];

        return json_encode($data);
    }

    public function orderArray()
    {
        return [
            ['name' => 'id', 'order' => true],
            ['name' => 'tenant.name', 'order' => true, 'relationship' => ['model' => 'tenant', 'column_name' => 'name']],
            ['name' => 'property.name', 'order' => true, 'relationship' => ['model' => 'property', 'column_name' => 'name']],
            ['name' => 'unit.number', 'order' => true, 'relationship' => ['model' => 'unit', 'column_name' => 'number']],
            ['name' => 'type.name', 'order' => true, 'relationship' => ['model' => 'type', 'column_name' => 'name']],
            ['name' => 'monthly_rent', 'order' => true],
            ['name' => 'monthly_rent', 'order' => true],
            ['name' => 'monthly_rent', 'order' => true],
            ['name' => 'lease_status_id', 'order' => true],
            ['name' => 'Action', 'order' => false],
            ['name' => 'created_at', 'visible' => false]
        ];
    }

    public function orderingColumn()
    {
        return json_encode([['10', 'desc']]);
    }

    public function getLeaseStatusAttribute()
    {

        $status = $this->status ? $this->status->slug : "";

        $status_name = $this->status ? $this->status->status : "";

        return View::make('panel.includes.status_mutator', compact('status', 'status_name'))->render();
    }

    public function getLeaseRentAttribute()
    {
        return addCommaForNumeric($this->monthly_rent);
    }

    public function getInvoiceStatusAttribute()
    {
        $status = 'in-active';

        $status_name = 'UnAvailable';

        if (count($this->invoices)) {
            $status = 'active';
            $status_name = 'Available';
        }

        return View::make('panel.includes.status_mutator', compact('status', 'status_name'))->render();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'lease_id');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'lease_id');
    }

    public function overDuePayments()
    {
        return $this->hasMany(OverduePayment::class, 'lease_id');
    }

    public function overDue()
    {
        return $this->hasMany(OverduePayment::class, 'lease_id');
    }

    public function getLeasePayableAttribute()
    {
        return addCommaForNumeric($this->monthly_rent);
    }

    public function getLeaseNameAttribute()
    {
        return $this->property->name . '/ Lease ' . $this->id;
    }

    public function getMonthRentAttribute()
    {
        return addCommaForNumeric($this->monthly_rent);
    }

    public function getPendingAmountAttribute()
    {
        $total_amount = $this->monthly_rent;

        foreach ($this->invoices as $invoice) {
            if ($invoice->status->slug == 'paid') {
                $total_amount = $total_amount - $invoice->total_amount;
            }
        }

        return addCommaForNumeric($total_amount);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function frequency()
    {
        return $this->belongsTo(Type::class, 'frequency_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'lease_status_id')->where('module', $this->getTable());
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id')->where('module', $this->getTable());
    }

    public function getActiveLeases()
    {
        $current_user = Auth()->user();

        $query = $this->whereHas('status', function ($q) {
            $q->where('slug', 'active');
        });

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
            $query = $query->whereHas('property.assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            });
        }

        return $query->get();
    }

    public function searchAjaxListing($request)
    {
        $current_user = Auth()->user();

        $query = $this->with(['tenant', 'type', 'property', 'status', 'unit', 'frequency']);

        if (isset($request['type'])) {

            $type = $request['type'];

            $query = $query->where('type_id', $type);

        }

        if (isset($request['status'])) {

            $status = $request['status'];

            $query = $query->where('lease_status_id', $status);

        }

        if (isset($request['property'])) {

            $property_id = $request['property'];

            $query = $query->where('property_id', $property_id);

        }

        if (isset($request['tenant_id'])) {

            $query = $query->where('tenant_id', $request['tenant_id']);

        }

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
            $query = $query->whereHas('property.assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            });
        }

        return $query;
    }

    public function getColumnsForReportsDataTable()
    {
        $data = [
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            ['data' => 'lease_name', 'name' => 'lease_name', 'title' => 'Lease Name'],
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
            ['data' => 'unit.number', 'name' => 'unit.number', 'title' => 'Unit'],
            ['data' => 'type.name', 'name' => 'type.name', 'title' => 'Type'],
            ['data' => 'pending_amount', 'name' => 'pending_amount', 'title' => 'Total Pending Amount', 'searchable' => 'false'],
            ['data' => 'lease_payable', 'name' => 'lease_payable', 'searchable' => 'false', 'title' => 'Lease Payable'],
            ['data' => 'invoice_status', 'name' => 'invoice_status', 'title' => 'Invoice Status', 'searchable' => 'false'],
            ['data' => 'lease_status', 'name' => 'lease_status', 'title' => 'Lease Status', 'searchable' => 'false'],
        ];

        return json_encode($data);
    }

    public function getExpiringLeaseForReports($user)
    {
        $user_model = new User();

        $query = $this->with(['type', 'property', 'status', 'unit']);

        $status_model = new Status();

        $status_id = $status_model->getStatusID($this->getTable(), 'active');

        $query = $query->whereMonth('end_date', '=', date('m'))->where('lease_status_id', $status_id);

        if (!in_array($user->role_id, $user_model->getSuperAdminRoleIds())) {
            $query = $query->whereHas('property.assigned_to', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        return $query;
    }

    public function tenantLeaseDetails($request)
    {
        return $this->with(['type', 'property', 'status', 'unit'])->where('tenant_id', $request['tenant_id']);
    }

    public function widgetData()
    {
        $widget_array['expiring_leases']['data'] = $this->totalLeaseExpiringThisMonth();

        $widget_array['expiring_leases']['title'] = 'Leases Expiring this Month';

        $overdue_model = new OverduePayment();

        $widget_array['over_due_amount']['data'] = $overdue_model->getTotalAmount();

        $widget_array['over_due_amount']['title'] = 'Total overdue amount';

        return $widget_array;
    }

    public function ajaxListing()
    {
        $current_user = Auth()->user();

        $query = $this->with(['tenant', 'type', 'property', 'status', 'unit', 'frequency']);

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
            $query = $query->whereHas('property.assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            });

        }

        return $query;
    }

    public function totalPendingAmount()
    {
        $status_model = new Status();

        $status_id = $status_model->getStatusID($this->getTable(), 'pending');

        return $this->ajaxListing()->where('lease_status_id', $status_id)->count();
    }

    public function totalLeaseExpiringThisMonth()
    {
        $status_model = new Status();

        $status_id = $status_model->getStatusID($this->getTable(), 'active');

        return $this->ajaxListing()->whereMonth('end_date', '=', date('m'))->where('lease_status_id', $status_id)->count();
    }


    public function totalApprovedLeases()
    {
        $status_model = new Status();
        $status_id = $status_model->getStatusID($this->getTable(), 'active');

        return $this->ajaxListing()->where('lease_status_id', $status_id)->count();
    }

    public function totalPendingLeases()
    {
        $status_model = new Status();
        $status_id = $status_model->getStatusID($this->getTable(), 'pending');

        return $this->ajaxListing()->where('lease_status_id', $status_id)->count();
    }

    public function getColumnsForExpiringLeaseDataTable()
    {
        $data = [
            //['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            ['data' => 'property.name', 'name' => 'property.name', 'title' => 'PROPERTY'],
            ['data' => 'unit.number', 'name' => 'unit.number', 'title' => 'UNIT'],
            ['data' => 'type.name', 'name' => 'type.name', 'title' => 'TYPE'],
            ['data' => 'lease_payable', 'name' => 'lease_payable', 'title' => 'LEASE AMOUNT', 'searchable' => 'false'],
            ['data' => 'end_date', 'name' => 'end_date', 'title' => 'EXPIRING ON', 'searchable' => 'false'],

        ];

        return json_encode($data);
    }

    public function expiringLeasesListing($request)
    {
        $current_user = Auth()->user();

        $next_month = date('m') + 1;

        $query = $this->with(['type', 'property', 'status', 'unit'])->whereMonth('end_date', '=', $next_month);

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
            $query = $query->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                !isset($request['search_by']['property']) ?: $q->where('property_id', $request['search_by']['property']);

                $q->where('user_id', $current_user->id);
            });
        }

        return $query;
    }

    public function leaseStatus()
    {
        $status_model = new Status();

        $current_user = Auth()->user();

        if (!in_array($current_user->role_id, $current_user->getLandLordRoleIds())) {

            return $status_model->getStatusID($this->getTable(), 'pending');

        }

        return $status_model->getStatusID($this->getTable(), 'active');
    }

    public function getDataForLeasingActivityBarGraph($value, $request)
    {
        $start_date = isset($request['start_date']) ? $request['start_date'] : '';
        $end_date = isset($request['end_date']) ? $request['end_date'] : '';

        if (!$start_date && !$end_date) {

            $start_date = date("Y-m-d", strtotime("this year January 1st"));
            $end_date = date("Y-m-d", strtotime("this year December 31st"));

        }

        $current_user = Auth()->user();

        $status_model = new Status();

        $ended_status_id = $status_model->getStatusID($this->getTable(), 'ended');

        $active_status_id = $status_model->getStatusID($this->getTable(), 'active');

        $graph_data = [];

        $graph_data['colors'] = ['window.chartColors.dodgerblue', 'window.chartColors.lipstick'];

        $graph_data['x'] = [tn('Leases Signed'), tn('Leases Terminated')];

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

            $leases_signed = $this->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                !isset($request['property']) ?: $q->where('property_id', $request['property']);

                $q->where('user_id', $current_user->id);

            })->whereRaw("YEAR(start_date) = '" . $month['year'] . "'")
                ->whereRaw("MONTHNAME(start_date) = '" . $month['month'] . "'")
                ->where('lease_status_id', $active_status_id)
                ->count();


            $graph_data['dataPoints'][$key] = !is_null($leases_signed) ? $leases_signed : 0;

            $leases_terminated = $this->whereHas('property.assigned_to', function ($q) use ($current_user, $request) {

                !isset($request['property']) ?: $q->where('property_id', $request['property']);

                $q->where('user_id', $current_user->id);

            })->whereRaw("YEAR(end_date) = '" . $month['year'] . "'")
                ->whereRaw("MONTHNAME(end_date) = '" . $month['month'] . "'")
                ->where('lease_status_id', $ended_status_id)
                ->count();


            $graph_data['dataPoints1'][$key] = !is_null($leases_terminated) ? $leases_terminated : 0;

        }

        $route_for_search = 'leases-leasing-activity-graph';

        $canvas_height = '150';

        return json_encode(compact('graph_data', 'route_for_search', 'canvas_height'));
    }

    function dateIsInBetween(\DateTime $from, \DateTime $to, \DateTime $subject)
    {
        return $subject->getTimestamp() > $from->getTimestamp() && $subject->getTimestamp() < $to->getTimestamp() ? true : false;
    }



}
