<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use League\Flysystem\Exception;
use PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable;

class Tenant extends Model
{
    use GlobalSearchable;

    protected $fillable = ['name', 'email', 'contact_number', 'national_id', 'tenant_status_id', 'creator_id',
        'age', 'gender', 'type_id', 'employee_id'];

    protected $appends = ['tenant_status'];

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
        'name', 'id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($tenant) {
            $unit_model = new Unit();
            $status_model = new Status();
            $unit_status_id = $status_model->getStatusID('units', 'active');

            foreach ($tenant->invoices as $invoice) {
                $invoice->delete();
            }

            foreach ($tenant->leases as $lease) {
                $unit_model->changeUnitStatus($lease->unit_id, $unit_status_id);
                $lease->delete();
            }
        });
    }

    public function getResidenceType($id)
    {

        $lease = Lease::where('tenant_id', $id)->select('residence_type')->whereNotNull('residence_type')->distinct()->get();

        foreach ($lease as $key => $value) {
            if ($value->residence_type == "commercial") {
                return "Commercial";
            }
        }
        return "Residential";
    }

    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Tenant Name'],
            ['data' => 'contact_number', 'name' => 'contact_number'],
            ['data' => 'tenant_status', 'name' => 'tenant_status_id', 'title' => 'Tenant Status', 'searchable' => 'true'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false'],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false]
        ];

        return json_encode($data);
    }

    public function orderArray()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'order' => true],
            ['data' => 'name', 'name' => 'name', 'order' => true],
            ['data' => 'contact_number', 'name' => 'contact_number', 'order' => true],
            ['data' => 'tenant_status_id', 'name' => 'tenant_status_id', 'order' => true],
            ['data' => 'action', 'name' => 'Action', 'order' => false],
            ['name' => 'created_at', 'order' => false]
        ];
    }

    public function orderingColumn()
    {
        return json_encode([['5', 'desc']]);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'tenant_id');
    }

    public function leases()
    {
        return $this->hasMany(Lease::class, 'tenant_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function getTenantStatusAttribute()
    {
        $status = $this->status->slug;

        $status_name = $this->status->status;

        return View::make('panel.includes.status_mutator', compact('status', 'status_name'))->render();
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'tenant_status_id')->where('module', $this->getTable());
    }

    public function getColumnsForReportsDatatable()
    {
        $data = [
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Tenant Name'],
            ['data' => 'contact_number', 'name' => 'contact_number', 'title' => 'Contact  Number'],
            ['data' => 'tenant_status', 'name' => 'tenant_status', 'title' => 'Status'],
        ];

        return json_encode($data);
    }

    public function getBlockedTenantsForReports($user)
    {
        $user_model = new User();

        $query = $this->whereHas('status', function ($q) {
            $q->where('slug', 'blocked');
        });

        if (!in_array($user->role_id, $user_model->getSuperAdminRoleIds())) {

            $query = $query->where(function ($q) use ($user) {
                $q->orwhere('creator_id', $user->id);

                $q->orwhere('employee_id', $user->id);

                $q->orwhereHas('leases.property.assigned_to', function ($q) use ($user) {

                    $q->where('user_id', $user->id);
                });
            });
        }

        return $query;
    }

    public function widgetData()
    {
        $widget_array['active_tenants']['data'] = count($this->getTenants('active'));

        $widget_array['active_tenants']['title'] = 'Active Tenants';

        $widget_array['in_active_tenants']['data'] = count($this->getTenants('in-active'));

        $widget_array['in_active_tenants']['title'] = 'In Active Tenants';

        $widget_array['pending_tenants']['data'] = count($this->getTenants('pending'));

        $widget_array['pending_tenants']['title'] = 'Pending Tenants';

        $widget_array['blocked_tenants']['data'] = count($this->getTenants('blocked'));

        $widget_array['blocked_tenants']['title'] = 'Blocked Tenants';

        return $widget_array;
    }

    public function ajaxListing()
    {
        $current_user = Auth()->user();

        $query = $this;

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {

            $query = $query->where(function ($q) use ($current_user) {
                $q->orwhere('creator_id', $current_user->id);

                $q->orwhere('employee_id', $current_user->id);

                $q->orwhereHas('leases.property.assigned_to', function ($q) use ($current_user) {

                    $q->where('user_id', $current_user->id);
                });
            });

        } else {
            $query = $query->query();
        }

        return $query;
    }


    public function getTenants($status = null)
    {
        $current_user = Auth()->user();

        $query = $this;

        if ($status) {
            $query = $query->whereHas('status', function ($q) use ($status) {

                if (is_array($status)) {

                    $q->whereIn('slug', $status);

                } else {

                    $q->where('slug', $status);
                }
            });
        }

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {

            $query = $query->where(function ($q) use ($current_user) {
                $q->orwhere('creator_id', $current_user->id);

                $q->orwhere('employee_id', $current_user->id);

                $q->orwhereHas('leases.property.assigned_to', function ($q) use ($current_user) {

                    $q->where('user_id', $current_user->id);
                });
            });
        }

        return $query->get();
    }

    public function tenantStatusAndCreator(&$request)
    {
        $status_model = new Status();

        $current_user = Auth()->user();

        if (!in_array($current_user->role_id, $current_user->getLandLordRoleIds())) {

            $status_id = $status_model->getStatusID($this->getTable(), 'pending');

            $request->merge([
                'employee_id' => $current_user->id,
                'creator_id' => $current_user->creator_id
            ]);

        } else {

            $status_id = $status_model->getStatusID($this->getTable(), 'active');
        }

        $request->merge(['tenant_status_id' => $status_id]);
    }

    public function changeTenantStatus($id, $status_id)
    {
        $this->findOrFail($id)->update(['tenant_status_id' => $status_id]);
    }

    public function globalSearch($query)
    {
        return $this->ajaxListing()->selectRaw('id as id, name as value,tenant_status_id')->where(function ($q) use ($query) {
            $q->orWhere('name', 'like', '%' . $query . '%');
            $q->orWhere('email', 'like', '%' . $query . '%');
            $q->orWhere('contact_number', 'like', '%' . $query . '%');
        })->get();
    }
}
