<?php

namespace App\Http\Controllers\Panel;

use App\Exports\PropertyExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Property\StoreProperty;
use App\Http\Requests\Property\UpdateProperty;
use App\Models\Country;
use App\Models\Lease;
use App\Models\PaymentMethod;
use App\Models\Property;
use App\Models\PropertyAssignedMapping;
use App\Models\Status;
use App\Models\Type;
use App\Models\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new Property();
        $this->property_assigned_model = new PropertyAssignedMapping();
        $this->type_model = new Type();
        $this->unit_model = new Unit();
        $this->user_model = new User();
        $this->status_model = new Status();
        $this->country_model = new Country();
        $this->units = new Unit();
        $this->lease_model = new Lease();
        $this->dataAssign['module'] = 'properties';
        $this->rawColumns = ['total_units', 'vacant_units', 'payment', 'action', 'property_status'];
        $this->dataAssign['actions'] = ['add', 'edit', 'view', 'delete'];
        $this->dataAssign['property_id']=null;
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';
        $this->dataAssign['ordering_column'] = $this->primary_model->orderingColumn();
        $this->dataAssign['ordering'] = true;
        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForDataTable();
    }

    public function setProperty($id){
        $this->dataAssign['property_id'] = $id;
    }

    public function getProperty(){
        return $this->dataAssign['property_id'];
    }


    public function show()
    {
        $this->getData();

        $this->dataAssign['widgets'] = $this->primary_model->widgetData();

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function getData()
    {
        $this->dataAssign['types'] = $this->type_model->getPropertyTypes();

        $this->dataAssign['countries'] = $this->country_model->get();

        $this->dataAssign['employees'] = $this->user_model->employeesAjaxListing()->get();

        $this->dataAssign['statuses'] = $this->status_model->getPropertyStatus();

        $this->dataAssign['total_properties'] = $this->primary_model->ajaxListing()->count();
    }

    public function getUnitType(Request $request){

        $type = $this->type_model->find($request->id);
        if($type && $type->slug==""){}
    }

    public function store(StoreProperty $storeProperty)
    {
        $country_row = Country::where('country_code',$storeProperty->country)->first();
        $storeProperty->merge(['country' => $country_row->id]);
        $status_id = $this->status_model->getStatusID($this->primary_model->getTable(), 'active');

        $storeProperty->merge(['property_status_id' => $status_id]);
        $storeProperty->merge(['land_lord_id'=>Auth::id()]);

        $property = $this->primary_model->create($storeProperty->only($this->primary_model->getFillable()));

        $assigned_tos = [Auth()->user()->id, $storeProperty->assigned_to];

        $storeProperty->merge(['assigned_to' => $assigned_tos]);

        $status_id = $this->status_model->getStatusID($this->primary_model->getTable(), 'active');

        $storeProperty->merge(['assigned_to' => $assigned_tos, 'property_status_id' => $status_id]);

        $this->property_assigned_model->assignProperties($property->id, $storeProperty->assigned_to);

        $storeProperty->session()->flash('activity_log_data', [
            'identifier' => 'property_added',
            'subject_type' => $property,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function delete($id)
    {
        $data = $this->primary_model->find($id);

        $data->delete();

        \request()->session()->flash('activity_log_data', [
            'identifier' => 'property_deleted',
            'subject_type' => $data,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
    }

    public function view($id)
    {
        $this->dataAssign['data'] = $this->primary_model->findOrFail($id);

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function edit($id)
    {
        $this->dataAssign['data'] = $this->primary_model->find($id);

        $this->dataAssign['property_id'] = $id;

        $this->dataAssign['property_assigned_to_id'] = $this->primary_model->getAssignedEmployeeId($id);
        $this->dataAssign['residence_type'] = $this->primary_model->getPropertyType($this->dataAssign['data']->type_id)->name;
        //dd($this->dataAssign['residence_type']);


        $this->getData();

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }



    public function update(UpdateProperty $updateProperty)
    {

        $country_row = Country::where('country_code',$updateProperty->country)->first();
        $updateProperty->merge(['country' => $country_row->id]);
        $property = $this->primary_model->find($updateProperty->id);


        if ($updateProperty->has('unit')) {
            $this->unit_model->attachUnits($updateProperty->unit, $updateProperty->id,$this->dataAssign['module']);
        }
        $property->update($updateProperty->only($this->primary_model->getFillable()));


        $assigned_tos = [Auth()->user()->id, $updateProperty->assigned_to];

        $updateProperty->merge(['assigned_to' => $assigned_tos]);

        $this->property_assigned_model->assignProperties($property->id, $updateProperty->assigned_to);

        $updateProperty->session()->flash('activity_log_data', [
            'identifier' => 'property_updated',
            'subject_type' => $property,
            'name' => 'name',
            'module' => $this->dataAssign['module'],
            'method' => __FUNCTION__
        ]);
        //$this->getData();

        return redirect($this->dataAssign['module']);
    }

    public function getUnitView($index,$property_id)
    {
        $this->dataAssign['index'] = $index;
        $this->dataAssign['property'] = $this->primary_model->find($property_id);
        return view($this->layout_base . '.includes.units', $this->dataAssign);
    }

    public function removeUnit($unit_id)
    {
        $unit = $this->unit_model->find($unit_id);

        if ($unit) {
            $unit->delete();
        }
    }

    public function getPropertyUnits(Request $request, $id)
    {
        $units = $this->primary_model->findOrFail($id)->units;
        $active_lease_status_id = $this->status_model->getStatusID($this->lease_model->getTable(), 'active');
        $occupied_unit_ids = $this->lease_model
            ->whereIn('unit_id', $units->pluck('id')->filter()->all() ?: [0])
            ->where('lease_status_id', $active_lease_status_id)
            ->whereDate('end_date', '>', date('Y-m-d'))
            ->pluck('unit_id')
            ->all();

        $this->dataAssign['data'] = $units;
        $this->dataAssign['occupied_unit_ids'] = $occupied_unit_ids;
        $this->dataAssign['sub_module'] = 'unit';
        $this->dataAssign['name'] = 'number';

        return view($this->layout_base . '.includes.unit', $this->dataAssign);
    }

    public function getResidenceUnitsType($id){

        $unit = $this->units->find($id);
        if (!$unit) {
            return response('Unit not found.', 404);
        }

        $this->dataAssign['unit'] = $unit;
        $this->dataAssign['occupied_error'] = null;

        $status_id = $this->status_model->getStatusID($this->lease_model->getTable(), 'active');
        $lease_data = $this->lease_model->where('unit_id', $id)->orderBy('created_at', 'DESC')->where('lease_status_id', $status_id)->first();

        if ($lease_data && date('Y-m-d') < $lease_data->end_date) {
            $this->dataAssign['occupied_error'] = 'This unit already has an active lease.';
        }

        return view($this->layout_base . '.includes.residents_type', $this->dataAssign);
    }

    public function search(Request $request)
    {
        $this->dataAssign['route_name_for_listing'] = $this->routeListingArray($request->all());

        $this->getData();

        $this->dataAssign['widgets'] = $this->primary_model->widgetData();

        $request->session()->put('search_property', $request->all());

        $this->dataAssign['search_property'] = app('session')->get('search_property');

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.show', $this->dataAssign);
    }

    public function routeListingArray($search)
    {
        return [
            'route' => $this->dataAssign['module'] . '.ajaxListing',
            'key' => 'search_by',
            'value' => $search
        ];
    }

    public function makeTotalPropertiesDataTable()
    {
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';

        $this->dataAssign['module'] = $this->dataAssign['module'];

        $this->dataAssign['ordering'] = true;

        return json_encode($this->dataAssign);
    }


    public function storeUnit(Request $request){

    }

    public function export()
    {
        return Excel::download(new PropertyExport(), time() . $this->dataAssign['module'] . '.xlsx');
    }

    public function getPropertyDataForPieChart()
    {
        $request = app('request');

        $widget_data = $this->primary_model->widgetData($request->all());

        $widget_data['total_properties']['data'] = $request->has('property') ? 1 : $this->primary_model->ajaxListing()->count();

        $widget_data['total_properties']['title'] = 'Total Properties';

        return json_encode($widget_data);
    }

    protected function ajaxListing()
    {
        $request = app('request');

        if ($request->has('search_by')) {

            $data = $this->primary_model->searchAjaxListing($request['search_by']);
        } else {

            $data = $this->primary_model->ajaxListing();
        }

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        $ordering = $this->dataAssign['ordering'];

        return $this->makeDataTable($data, $actions, $module, $ordering);
    }

    public function getDataForUnitBarGraph($value = null)
    {
        $request = app('request');

        return $this->unit_model->getDataForUnitBarGraph($value, $request->all());
    }

    public function getDataForPropertyBarometer()
    {
        $request = app('request');

        return $this->primary_model->getDataForPropertyBarometer($request->all());
    }

    public function getDataForVacancyBarometer()
    {
        $request = app('request');

        return $this->unit_model->getDataForVacancyBarometer($request->all());
    }

    public function getUnitForDateRange()
    {
        $request = app('request');

        return $this->primary_model->getUnitForDateRange($request->all());
    }
}
