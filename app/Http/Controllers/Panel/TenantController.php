<?php

namespace App\Http\Controllers\Panel;

use App\Exports\TenantExport;
use App\Http\Requests\Tenant\StoreTenant;
use App\Http\Requests\Tenant\UpdateTenant;
use App\Models\Lease;
use App\Models\OverduePayment;
use App\Models\Property;
use App\Models\Status;
use App\Models\Tenant;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Maatwebsite\Excel\Facades\Excel;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new Tenant();
        $this->status_model = new Status();
        $this->type_model = new Type();
        $this->lease = new Lease();
        $this->property_model = new Property();
        $this->status = new Status();
        $this->invoice = new Invoice();
        $this->over_due_moodel = new OverduePayment();
        $this->dataAssign['module'] = 'tenants';
        $this->rawColumns = ['tenant_status', 'action'];
        $this->dataAssign['actions'] = ['add', 'edit', 'view', 'delete', 'lease_details', 'payment_history', 'approve_tenant'];
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';
        $this->dataAssign['ordering_column'] = $this->primary_model->orderingColumn();
        $this->dataAssign['ordering'] = true;
        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForDataTable();
    }

    public function show()
    {
        $this->dataAssign['widgets'] = $this->primary_model->widgetData();

        $this->dataAssign['types'] = $this->type_model->getTenantTypes();

        $this->dataAssign['total_tenants'] = $this->primary_model->ajaxListing()->count();

        $this->getData();

        // dd($this->dataAssign);


        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function store(StoreTenant $storeTenant)
    {
        $this->primary_model->tenantStatusAndCreator($storeTenant);

        $tenant = $this->primary_model->create($storeTenant->only($this->primary_model->getFillable()));

        $storeTenant->session()->flash('activity_log_data', [
            'identifier' => 'tenant_added',
            'subject_type' => $tenant,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function getData()
    {

        $leases = $this->lease::get();
        $properties_tenant = [];
        for ($i = 0; $i < count($leases); $i++) {
            $property = $this->property_model::where('id', $leases[$i]->property_id)->first();
            $tenant = $this->primary_model::where('id', $leases[$i]->tenant_id)->first();

            if(isset($property))
            {
                $properties_tenant[$property->name] = isset($properties_tenant[$property->name]) ? $properties_tenant[$property->name] : [];
                if (!in_array($tenant->name, $properties_tenant[$property->name])) {
                    array_push($properties_tenant[$property->name], $tenant->name);
                }
            }


        }
        foreach ($properties_tenant as $key => $value) {
            $ten = implode('|', $value);
            $properties_tenant[$key] = $ten;
        }


        $this->dataAssign['properties'] = $properties_tenant;
        $this->dataAssign['statuses'] = $this->status_model::where('module', 'tenants')->get();


    }

    public function edit($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);

        $this->dataAssign['statuses'] = $this->status_model->getTenantStatus();

        $this->dataAssign['types'] = $this->type_model->getTenantTypes();


        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function view($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);
        $response  = $this->invoice->getWaivedAmount($id);
        $this->dataAssign['waived_amount'] = $response['waived_amount'];
        $this->dataAssign['overdue_amount'] = $response['overdue_amount'];
        $this->dataAssign['advance_payments'] = $response['advance_payments'];
        $this->dataAssign['deposit'] = $response['deposit'];
        $lease = $this->primary_model->getResidenceType($id);

        $this->dataAssign['data']['residence_type'] = $lease;


        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function update(UpdateTenant $updateTenant)
    {
        $tenant = $this->primary_model->find($updateTenant->id);

        $tenant->update($updateTenant->only($this->primary_model->getFillable()));

        $updateTenant->session()->flash('activity_log_data', [
            'identifier' => 'tenant_updated',
            'subject_type' => $tenant,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);

        return redirect($this->dataAssign['module']);
    }

    public function delete($id)
    {
        $data = $this->primary_model->find($id);

        $data->delete();

        $this->over_due_moodel->where('tenant_id', $id)->delete();

        \request()->session()->flash('activity_log_data', [
            'identifier' => 'tenant_deleted',
            'subject_type' => $data,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function getTenantData($id)
    {
        return $this->primary_model->findOrFail($id);
    }

    public function makeTotalTenantsDataTable()
    {
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.allTenants';

        $this->dataAssign['module'] = $this->dataAssign['module'];

        $this->dataAssign['ordering'] = true;

        return json_encode($this->dataAssign);
    }

    public function getAllTenantsListing()
    {
        $data = $this->primary_model::query();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    protected function ajaxListing()
    {
        $data = $this->primary_model->ajaxListing();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    public function makeTenantsDatatable()
    {
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';

        $this->dataAssign['module'] = $this->dataAssign['module'];

        $this->dataAssign['ordering'] = true;

        return json_encode($this->dataAssign);
    }

    public function export()
    {
        return Excel::download(new TenantExport(), time() . $this->dataAssign['module'] . '.xlsx');
    }

    public function approveTenant($id)
    {
        $status_id = $this->status_model->getStatusID($this->dataAssign['module'], 'in-active');

        $this->primary_model->changeTenantStatus($id, $status_id);

        return back();
    }
}
