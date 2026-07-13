<?php

namespace App\Http\Controllers\Panel;

use App\Models\Property;
use App\Models\Widget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new Widget();
        $this->property_model = new Property();
        $this->dataAssign['module'] = 'dashboard';
    }

    public function index(Request $request)
    {
        $current_user = auth()->user();

        $widgets = $this->primary_model->getWidgets($current_user);

        $this->dataAssign['widgets'] = $this->primary_model->getQueryResult($widgets);

        $this->dataAssign['listing_data'] = $this->primary_model->getListingData($widgets);

        $this->dataAssign['graph_data'] = $this->primary_model->getGraphData($widgets);

        if (checkInMultiDeminsionalArray(Auth()->user()->excludeDashboardRoleIds(), 'role_id', Auth()->user()->role_id)) {
            return redirect(route(
                checkInMultiDeminsionalArray(
                    Auth()->user()->excludeDashboardRoleIds(),
                    'role_id',
                    Auth()->user()->role_id,
                    true
                )['redirection_route_name']
            ));
        }

        $this->dataAssign['properties'] = $this->property_model->ajaxListing()->get();

        $this->dataAssign['property_id'] = $request->property;
        // dd($this->dataAssign['widgets'][0]);
        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function dateFilter(){
        $dashCards = [];
        $current_user = auth()->user();
        $widgets = $this->primary_model->getWidgets($current_user);
        $this->dataAssign['widgets'] = $this->primary_model->getQueryResult($widgets);
        foreach($this->dataAssign['widgets'] as $key => $value){
            if($key <= 3){
                array_push($dashCards, $value);
            }
        }
        return $dashCards;
    }
    public function dateFilter2(){
        return response()->json(['error' => true],403);
    }
}
