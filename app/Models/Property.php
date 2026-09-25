<?php

namespace App\Models;

use App\User;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable;

class Property extends Model
{
    use GlobalSearchable, EloquentJoin;

    protected $fillable = ['name', 'address', 'paci_id', 'type_id', 'country', 'property_status_id', 'longitude', 'latitude', 'land_lord_id'];

    protected $appends = ['total_units', 'vacant_units', 'occupied_units', 'land_lord', 'employee', 'property_status'];

    /**
     * The columns that should be ordered.
     *
     * @var array
     */
    protected $order = [
        'name' => 'desc',
    ];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    protected $search = [
        'name'
    ];

    /**
     * The columns that should be displayed.
     *
     * @var array
     */
    protected $only = [
        'name',
        'id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($property) {
            foreach ($property->invoices as $invoice) {
                $invoice->delete();
            }
            foreach ($property->units as $unit) {
                $unit->delete();
            }
            foreach ($property->leases as $lease) {
                $lease->delete();
            }
            foreach ($property->overDuePayments as $overDuePayment) {
                $overDuePayment->delete();
            }
        });
    }

    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'address', 'name' => 'address'],
            ['data' => 'occupied_units', 'name' => 'occupied_units', 'searchable' => 'false'],
            ['data' => 'vacant_units', 'name' => 'vacant_units', 'searchable' => 'false'],
            ['data' => 'total_units', 'name' => 'total_units', 'searchable' => 'false'],
            ['data' => 'property_status', 'name' => 'property_status', 'title' => 'Property Status', 'searchable' => 'false'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false', 'title' => ''],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false]
        ];

        return json_encode($data);
    }

    public function orderArray()
    {
        return [
            ['name' => 'id', 'order' => true],
            ['name' => 'name', 'order' => true],
            ['name' => 'address', 'order' => true],
            ['name' => 'id', 'order' => true],
            ['name' => 'id', 'order' => true],
            ['name' => 'id', 'order' => true],
            ['name' => 'property_status_id', 'order' => true],
            ['name' => 'Action', 'order' => false],
            ['name' => 'created_at', 'order' => false]
        ];
    }

    public function orderingColumn()
    {
        return json_encode([['8', 'desc']]);
    }

    public function getTotalUnitsAttribute()
    {
        return $this->units->count();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'property_id');
    }

    public function leases()
    {
        return $this->hasMany(Lease::class, 'property_id');
    }

    public function overDuePayments()
    {
        return $this->hasMany(OverduePayment::class, 'property_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'property_status_id');
    }

    public function assigned_to()
    {
        return $this->belongsToMany(User::class, 'property_assigned_mappings');
    }


    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function getVacantUnitsAttribute()
    {
        $units = $this->units;

        $vacant_units = 0;

        foreach ($units as $unit) {
            if ($unit->status->slug == 'active') {
                $vacant_units++;
            }
        }

        return $vacant_units;
    }

    public function getOccupiedUnitsAttribute()
    {
        $units = $this->units;

        $occupied_units = 0;

        foreach ($units as $unit) {
            if ($unit->status->slug != 'active') {
                $occupied_units++;
            }
        }

        return $occupied_units;
    }

    public function getPropertyStatusAttribute()
    {
        $status = $this->status->slug;

        $status_name = $this->status->status;

        return View::make('panel.includes.status_mutator', compact('status', 'status_name'))->render();
    }

    public function getLandLordAttribute()
    {
        $query = $this->assigned_to()
            ->whereIn('role_id', Auth()->user() ? Auth()->user()->getLandLordRoleIds() : []);

        return isset($query->first()->name) ? $query->first()->name : '';
    }

    public function getEmployeeAttribute()
    {
        $query = $this->assigned_to()
            ->whereIn('role_id', Auth()->user() ? Auth()->user()->getEmployeeRoleIds() : []);

        return isset($query->first()->name) ? $query->first()->name : '';
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'property_id');
    }

    public function getActiveProperties()
    {
        $current_user = Auth()->user();

        $query = $this->whereHas('status', function ($q) {
            $q->where('slug', 'active');
        });

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
            $query = $query->whereHas('assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            });
        }

        return $query->get();
    }

    public function searchAjaxListing($request)
    {
        $current_user = Auth()->user();

        $status_id = isset($request['status']) ? $request['status'] : '';

        $query = $this->with(['countries'])->orWhere('property_status_id', $status_id);

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
            $query = $query->whereHas('assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            });
        }

        return $query;
    }

    public function widgetData($request = '')
    {
        $widget_array['total_units']['data'] = $this->totalUnits($request);

        $widget_array['total_units']['title'] = 'Total Units';

        $widget_array['vacant_units']['data'] = $this->vacantUnits($request);

        $widget_array['vacant_units']['title'] = 'Vacant Units';

        $widget_array['occupied_units']['data'] = $widget_array['total_units']['data'] - $widget_array['vacant_units']['data'];

        $widget_array['occupied_units']['title'] = 'Occupied Units';

        return $widget_array;
    }

    public function ajaxListing()
    {
        $current_user = Auth()->user();

        $query = $this->with(['countries', 'units']);

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {

            $query = $query->whereHas('assigned_to', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            });
        }

        return $query;
    }

    public function totalUnits($request)
    {
        if (isset($request['property'])) {
            $properties = $this->ajaxListing()->where('id', $request['property'])->get();
        } else {

            $properties = $this->ajaxListing()->get();
        }


        $total_units = 0;

        foreach ($properties as $property) {

            $total_units += count($property->units);
        }
        return $total_units;
    }

    public function vacantUnits($request)
    {
        if (isset($request['property'])) {
            $properties = $this->ajaxListing()->where('id', $request['property'])->get();
        } else {

            $properties = $this->ajaxListing()->get();
        }

        $vacant_units = 0;

        foreach ($properties as $property) {

            $vacant_units += (int)$property->vacant_units;
        }

        return $vacant_units;
    }

    public function getAssignedEmployeeId($property_id)
    {
        $user_model = new User();

        $property_assigned_to = $this->findOrFail($property_id)->assigned_to()
            ->whereIn('role_id', $user_model->getEmployeeRoleIds())
            ->first();
        if ($property_assigned_to)
            return $property_assigned_to->id;
    }

    public function getAssignedLandlordId($property_id)
    {
        $user_model = new User();

        $property_assigned_to = $this->findOrFail($property_id)->assigned_to()
            ->whereIn('role_id', $user_model->getLandLordRoleIds())
            ->first();
        if ($property_assigned_to)
            return $property_assigned_to->id;
    }

    public function globalSearch($query)
    {
        return $this->ajaxListing()->selectRaw('id as id, name as value,property_status_id')->where(function ($q) use ($query) {
            $q->orWhere('name', 'like', '%' . $query . '%');
            $q->orWhere('address', 'like', '%' . $query . '%');
        })->get();
    }

    public function getDataForPropertyBarometer($request)
    {
        $invoice_model = new Invoice();
        $type_model = new Type();
        $revenue_type_id = $type_model->getTypeId($invoice_model->getTable(), 'revenue');
        $status_ids = Status::where('module', 'invoices')
            ->whereIn('slug', ['approved', 'paid'])
            ->pluck('id');

        $collected = function () use ($invoice_model, $revenue_type_id, $status_ids, $request) {
            $query = $invoice_model->ajaxlisting()
                ->where('type_id', $revenue_type_id)
                ->whereIn('invoice_status_id', $status_ids);

            if (!empty($request['property'])) {
                $query->where('property_id', $request['property']);
            }

            return $query;
        };

        $data['value'] = $collected()
            ->whereYear('end_date', date('Y'))
            ->sum('total_amount') ?: 0;

        $data['monthly_income'] = $collected()
            ->whereYear('end_date', date('Y'))
            ->whereMonth('end_date', date('m'))
            ->sum('total_amount') ?: 0;

        return json_encode($data);
    }

    public function getPropertyType($id)
    {
        return Type::where("id", $id)->first();
    }

    public function getLandLordActiveProperties($land_lord_id)
    {
        $query = $this->whereHas('status', function ($q) {
            $q->where('slug', 'active');
        });

        $query = $query->whereHas('assigned_to', function ($q) use ($land_lord_id) {
            $q->where('user_id', $land_lord_id);
        });


        return $query->get();
    }

    public function getUnitForDateRange($request)
    {
        if (isset($request['start_date']) && isset($request['end_date'])) {
            $properties = $this->whereBetween('created_at', [$request['start_date'], $request['end_date']])->get();
        }
        $vacant_units = 0;
        $total_units = 0;
        $occupied_units = 0;
        foreach ($properties as $property) {
            $total_units += count($property->units);
            $vacant_units += (int)$property->vacant_units;
            $occupied_units = $total_units - $vacant_units;
        }
        $widget_array['total_units']['data'] = $total_units;
        $widget_array['total_units']['title'] = 'Total Units';
        $widget_array['vacant_units']['data'] = $vacant_units;
        $widget_array['vacant_units']['title'] = 'Vacant Units';
        $widget_array['occupied_units']['data'] = $occupied_units;
        $widget_array['occupied_units']['title'] = 'Occupied Units';

        return $widget_array;
    }

}
