<?php

namespace App\Http\Controllers\Panel;

use App\Exports\LeaseExport;
use App\Http\Requests\Lease\StoreLease;
use App\Http\Requests\Lease\UpdateLease;
use App\Models\Invoice;
use App\Models\Lease;
use App\Models\OverduePayment;
use App\Models\PaymentMethod;
use App\Models\Property;
use App\Models\Status;
use App\Models\Tenant;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LeaseController extends Controller
{

    protected $primary_model;
    protected $overdue_model;
    protected $tenant_model;
    protected $status_model;
    protected $unit_model;
    protected $dataAssign;

    public function __construct()
    {
        $this->primary_model = new Lease();
        $this->overdue_model = new OverduePayment();
        $this->type_model = new Type();
        $this->tenant_model = new Tenant();
        $this->invoice_model = new Invoice();
        $this->property_model = new Property();
        $this->unit_model = new Unit();
        $this->payment_method_model = new PaymentMethod();
        $this->status_model = new Status();
        $this->dataAssign['module'] = 'leases';
        $this->rawColumns = ['lease_status', 'lease_payable', 'pending_amount', 'invoice_status', 'month_rent', 'action', 'overdue_comment'];
        // $this->dataAssign['actions'] = ['view_transactions', 'add', 'edit', 'view', 'delete', 'end_lease', 'approve_lease', 'add_lease_invoice','send_invoice'];
        $this->dataAssign['actions'] = ['view_transactions', 'add', 'edit', 'view', 'delete', 'end_lease', 'approve_lease', 'send_invoice'];
        $this->dataAssign['over_due_actions'] = ['add_comment'];
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';
        $this->dataAssign['ordering_column'] = $this->primary_model->orderingColumn();
        $this->dataAssign['ordering_column_overdue'] = $this->overdue_model->orderingColumnForOverdueLease();
        $this->dataAssign['ordering'] = true;
        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForDataTable();
    }

    public function show()
    {
        $this->getData();

        $this->listingData();


        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function getData()
    {
        $this->dataAssign['types'] = $this->type_model->getLeaseTypes();

        $this->dataAssign['payment_methods'] = $this->payment_method_model->getLeasePaymentsMethods();

        $this->dataAssign['properties'] = $this->property_model->getActiveProperties();

        $this->dataAssign['tenants'] = $this->tenant_model->getTenants(['active', 'in-active']);

        $this->dataAssign['frequencies'] = $this->type_model->getLeaseFrequencyTypes();

        $this->dataAssign['statuses'] = $this->status_model->getLeaseStatus();

        $this->dataAssign['pending_leases'] = $this->primary_model->totalPendingLeases();

        $this->dataAssign['approved_leases'] = $this->primary_model->totalApprovedLeases();

        $this->dataAssign['total_leases'] = $this->primary_model->ajaxListing()->count();
    }

    public function storeMedia(Request $request)
    {
        $path = public_path('files');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    // public function store(StoreLease $storeLease)
    // {
    //     if ($storeLease->hasFile('file')) {
    //         $image = $storeLease->file('file');
    //         $attachment_name = $image->getClientOriginalName();
    //         $new_name = rand() . '.' . $image->getClientOriginalExtension();
    //         $image_path = '/images/' . $new_name;
    //         $storeLease['attachments'] = $image_path;
    //         $storeLease->merge(['attachments' => $image_path, 'attachment_name' => $attachment_name]);
    //     }
    //     $marriage_status = $storeLease->residence_type == 'residential' ? $storeLease->marriage_status : '';
    //     if (!is_null($storeLease->notification)) {
    //         foreach ($storeLease->notification as $key => $value) {
    //             $storeLease->merge(['enable_' . $value => "1"]);
    //         }
    //     }
    //     $status_id = $this->primary_model->leaseStatus();
    //     $storeLease->merge(['lease_status_id' => $status_id]);
    //     $storeLease->merge(["marriage_status" => $marriage_status]);
    //     $lease = $this->primary_model->create($storeLease->only($this->primary_model->getFillable()));
    //         // Calculate overdue amount
    //         $start_date = \Carbon\Carbon::parse($storeLease->start_date);
    //         $end_date = \Carbon\Carbon::parse($storeLease->end_date);

    //         // Calculate total months
    //         $total_months = $start_date->diffInMonths($end_date);

    //         // Calculate overdue amount
    //         $overdue_amount = $total_months * $storeLease->monthly_rent;
    //         // Store overdue payment record
    //         OverduePayment::create([
    //             'lease_id' => $lease->id,
    //             'amount' => $overdue_amount,
    //             'date' => now(),
    //             'tenant_id' => $lease->tenant_id,
    //             'property_id' => $lease->property_id,
    //             'unit_id' => $lease->unit_id,
    //             'comment' => 'Overdue amount calculated from lease start to end date',
    //             'commented_by' => auth()->id()
    //         ]);
    //     $unit_status_id = $this->status_model->getStatusID('units', 'in-active');
    //     $this->unit_model->changeUnitStatus($storeLease->unit_id, $unit_status_id);
    //     $tenant_status_id = $this->status_model->getStatusID('tenants', 'active');
    //     $this->tenant_model->changeTenantStatus($storeLease->tenant_id, $tenant_status_id);
    //     $storeLease->session()->flash('activity_log_data', [
    //         'identifier' => 'lease_added',
    //         'subject_type' => $lease,
    //         'name' => 'lease_name',
    //         'module' => $this->dataAssign['module'],
    //         'method' => __FUNCTION__
    //     ]);
    // }
    public function store(StoreLease $storeLease)
    {
        if ($storeLease->hasFile('file')) {
            $image = $storeLease->file('file');
            $attachment_name = $image->getClientOriginalName();
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $path = $image->move(public_path() . '/images', $new_name);
            $image_path = '/images/' . $new_name;
            $storeLease['attachments'] = $image_path;
            $storeLease->merge(['attachments' => $image_path, 'attachment_name' => $attachment_name]);
        }
        $marriage_status = $storeLease->residence_type == 'residential' ? $storeLease->marriage_status : '';
        if (!is_null($storeLease->notification)) {
            foreach ($storeLease->notification as $key => $value) {
                $storeLease->merge(['enable_' . $value => "1"]);
            }
        }
        $status_id = $this->primary_model->leaseStatus();
        $storeLease->merge(['lease_status_id' => $status_id]);
        $storeLease->merge(["marriage_status" => $marriage_status]);
        $lease = $this->primary_model->create($storeLease->only($this->primary_model->getFillable()));
        $unit_status_id = $this->status_model->getStatusID('units', 'in-active');
        $this->unit_model->changeUnitStatus($storeLease->unit_id, $unit_status_id);
        $tenant_status_id = $this->status_model->getStatusID('tenants', 'active');

        // if ($storeLease->has('attachments')) {
        //     foreach ($storeLease->input('attachments', []) as $file) {
        //         $lease->addMedia(public_path('files/' . $file))->toMediaCollection($this->primary_model->getTable());
        //     }
        // }
        $this->tenant_model->changeTenantStatus($storeLease->tenant_id, $tenant_status_id);
        $storeLease->session()->flash('activity_log_data', [
            'identifier' => 'lease_added',
            'subject_type' => $lease,
            'name' => 'lease_name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function delete($id)
    {
        $data = $this->primary_model->find($id);

        $data->delete();

        $this->overdue_model->where('lease_id', $id)->delete();

        $unit_status_id = $this->status_model->getStatusID('units', 'active');

        $this->unit_model->findOrFail($data->unit_id)->update(['unit_status_id' => $unit_status_id]);

        $tenant_status_id = $this->status_model->getStatusID('tenants', 'in-active');

        $this->tenant_model->changeTenantStatus($data->tenant_id, $tenant_status_id);

        \request()->session()->flash('activity_log_data', [
            'identifier' => 'lease_deleted',
            'subject_type' => $data,
            'name' => 'lease_name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function edit($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);

        //$this->dataAssign['data']->attachments = $this->dataAssign['data']->getMedia($this->primary_model->getTable());
        //dd($this->dataAssign);
        $property_id = $this->dataAssign['data']->property_id;

        $this->dataAssign['units'] = $this->unit_model->getActiveUnits($property_id);


        $this->getData();

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function view($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);
        $this->dataAssign['overdue_amount'] = $this->overdue_model->where('lease_id', $id)->sum('amount');

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function update(UpdateLease $updateLease)
    {
        // return ("hello");
        if ($updateLease->hasFile('file')) {
            $image = $updateLease->file('file');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $path = $image->move(public_path() . '/images', $new_name);
            $image_path = '/images/' . $new_name;

            $image_name = $image->getClientOriginalName();
            //print_r($image_path);die;
            $updateLease->merge(['attachments' => $image_path, 'attachment_name' => $image_name]);
        }

        if (!$updateLease->has('deposit')) {
            $updateLease->merge(['deposit' => 0]);
        }


        $lease = $this->primary_model->find($updateLease->id);

        $rental = $updateLease->type_id == 3 ? $updateLease->rental : '';
        $marriage_status = $updateLease->residence_type == 'residential' ? $updateLease->marriage_status : '';
        $updateLease->merge([
            'enable_email' => $updateLease->enable_email ? 1 : 0,
            'enable_sms' => $updateLease->enable_sms ? 1 : 0,
            'rental' => $rental,
            "marriage_status" => $marriage_status,
            "residence_type" => $updateLease->residence_type
        ]);

        $lease->update($updateLease->only($this->primary_model->getFillable()));

        $updateLease->session()->flash('activity_log_data', [
            'identifier' => 'lease_updated',
            'subject_type' => $lease,
            'name' => 'lease_name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);

        return redirect($this->dataAssign['module']);
    }

    public function cancelLease($id)
    {
        $status_id = $this->status_model->getStatusID($this->dataAssign['module'], 'cancelled');

        $lease = $this->primary_model->findOrFail($id);

        $lease->update(['lease_status_id' => $status_id]);

        $unit_status_id = $this->status_model->getStatusID('units', 'active');

        $this->unit_model->changeUnitStatus($lease->unit_id, $unit_status_id);

        $tenant_status_id = $this->status_model->getStatusID('tenants', 'in-active');

        $this->tenant_model->changeTenantStatus($lease->tenant_id, $tenant_status_id);

        \request()->session()->flash('activity_log_data', [
            'identifier' => 'lease_cancelled',
            'subject_type' => $lease,
            'name' => 'lease_name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);

        return back();
    }

    public function endLease($id)
    {
        $status_id = $this->status_model->getStatusID($this->dataAssign['module'], 'ended');

        $lease = $this->primary_model->findOrFail($id);

        $lease->update(['lease_status_id' => $status_id]);

        $unit_status_id = $this->status_model->getStatusID('units', 'active');

        $this->unit_model->changeUnitStatus($lease->unit_id, $unit_status_id);

        $tenant_status_id = $this->status_model->getStatusID('tenants', 'in-active');

        $this->tenant_model->changeTenantStatus($lease->tenant_id, $tenant_status_id);

        \request()->session()->flash('activity_log_data', [
            'identifier' => 'lease_ended',
            'subject_type' => $lease,
            'name' => 'lease_name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);

        return back();
    }

    public function approveLease($id)
    {
        $status_id = $this->status_model->getStatusID($this->dataAssign['module'], 'active');

        $lease = $this->primary_model->findOrFail($id);

        $lease->update(['lease_status_id' => $status_id]);

        return back();
    }

    public function addInvoice($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);

        $this->dataAssign['module'] = 'invoices';

        $this->dataAssign['payment_methods'] = $this->payment_method_model->getInvoicePaymentMethods();

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.future_invoice', $this->dataAssign);
    }

    public function search(Request $request)
    {
        $this->dataAssign['route_name_for_listing'] = $this->routeListingArray($request->all());

        $this->getData();

        $this->listingData();

        $this->dataAssign['overdue_route_name'] = $this->routeListingArray($request->all(), 'overdueLeaseInvoices');;

        $request->session()->put('search_lease', $request->all());

        $this->dataAssign['search_lease'] = app('session')->get('search_lease');

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.show', $this->dataAssign);
    }

    public function routeListingArray($search, $route = 'ajaxListing')
    {
        return [
            'route' => $this->dataAssign['module'] . '.' . $route,
            'key' => 'search_by',
            'value' => $search
        ];
    }

    public function export()
    {
        return Excel::download(new LeaseExport(), time() . $this->dataAssign['module'] . '.xlsx');
    }

    public function makeExpiringLeasesDataTable()
    {
        $request = app('request');

        if (isset($request->property)) {

            $this->dataAssign['route_name_for_listing'] = $this->routeListingArray($request->all(), 'expiringLeases');
        } else {
            $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.expiringLeases';
        }

        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForExpiringLeaseDataTable();

        $this->dataAssign['module'] = $this->dataAssign['module'];

        $this->dataAssign['paging'] = true;

        $this->dataAssign['ordering'] = 'false';

        return json_encode($this->dataAssign);
    }

    public function expiringLeasesListing()
    {
        $request = app('request');

        $data = $this->primary_model->expiringLeasesListing($request->all());

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        return $this->makeDataTable($data, $actions, $module);
    }

    protected function ajaxListing()
    {
        $request = app('request');

        if ($request->has('search_by')) {

            $data = $this->primary_model->searchAjaxListing($request['search_by']);
        } else {
            if (!is_null($request['search']['value'])) {
                if (str_contains($request['search']['value'], 'KWD')) {
                    $string = str_replace(array("KWD ", ","), array("", ""), $request['search']['value']);
                    $request->merge(['search' => ['value' => $string, 'regex' => 'false']]);
                }
            }
            $data = $this->primary_model->ajaxListing();
        }
        $actions = $this->dataAssign['actions'];


        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    public function listingData()
    {
        $this->dataAssign['widgets'] = $this->primary_model->widgetData();

        $this->dataAssign['overdue_route_name'] = $this->primary_model->getTable() . '.overdueLeaseInvoices';

        $this->dataAssign['overdue_data_table_columns'] = $this->overdue_model->getColumnsForOverDueLeaseAmountDataTable();
        //dd($this->dataAssign['overdue_data_table_columns']);
    }

    public function getDataForLeasingActivityBarGraph($value = null)
    {
        $request = app('request');

        return $this->primary_model->getDataForLeasingActivityBarGraph($value, $request->all());
    }

    public function getWaivedAmount($tenant_id)
    {
        return $this->invoice_model->getWaivedAmount($tenant_id);
    }

    public function overdueInvoicesListing()
    {
        $request = app('request');

        $data = $this->overdue_model->overdueAjaxListing($request->has('search_by') ? $request['search_by'] : []);

        $actions = $this->dataAssign['over_due_actions'];

        $module = $this->overdue_model->getTable();

        $order_array = $this->overdue_model->orderArrayForOverdue();

        return $this->makeDataTable($data, $actions, $module, true, 'created_at', $order_array);
    }

    public function leaseOverdueInvoicesListing()
    {
        $request = app('request');

        $data = $this->overdue_model->overdueAjaxListing($request->has('search_by') ? $request['search_by'] : []);

        $actions = $this->dataAssign['over_due_actions'];

        $module = $this->overdue_model->getTable();

        $order_array = $this->overdue_model->orderArrayForOverdue();

        return $this->makeDataTable($data, $actions, $module, true, 'created_at', $order_array);
    }

    public function overdueLeaseInvoicesListing()
    {
        $request = app('request');

        /*  if(!is_null($request['search']['value'])){
            if (str_contains($request['search']['value'], 'KWD')) {
                $string = str_replace(array("KWD ",","),array("",""),$request['search']['value']);
                $request->merge(['search' => ['value'=> $string,'regex'=>'false']]) ;
            }
        } */


        $data = $this->overdue_model->overdueAjaxListing($request->has('search') ? $request['search'] : []);

        $actions = $this->dataAssign['over_due_actions'];


        $module = $this->overdue_model->getTable();

        $order_array = $this->overdue_model->orderArrayForOverdueLease();

        return $this->makeDataTable($data, $actions, $module, true, 'created_at', $order_array);
    }

    public function addCommentOverDue(Request $request)
    {
        $this->overdue_model->findOrFail($request->id)->update(['comment' => $request->comment, 'commented_by' => Auth::id()]);
    }

    public function viewCommentOverDue($id)
    {
        $data = $this->overdue_model->findOrFail($id);

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.add_comment', compact('data'));
    }

    public function removeLeaseFile($id)
    {
        $this->primary_model->find($id)->update(['attachments' => null, 'attachment_name' => null]);
    }
}
