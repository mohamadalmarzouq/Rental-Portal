<?php

namespace App\Http\Controllers\Panel;

use App\Models\Property;
use App\Models\Type;
use App\Models\Widget;
use App\Models\WidgetUser;
use App\Repositories\Search\SearchFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->seach_filter_repo = new SearchFilter();
        $this->widget_model = new Widget();
        $this->widget_user_model = new WidgetUser();
        $this->property_model = new Property();
        $this->rawColumns = ['tenant_status', 'invoice_status', 'lease_status'];
        $this->dataAssign['module'] = 'reports';
    }

    public function show(Request $request)
    {
        // dd($request);
        $current_user = auth()->user();

        $widgets = $this->widget_model->getWidgetsForReports($current_user);

        $this->dataAssign['widgets'] = $this->widget_model->getQueryResult($widgets);

        $this->dataAssign['listing_data'] = $this->widget_model->getListingData($widgets);

        $this->dataAssign['graph_data'] = $this->widget_model->getGraphData($widgets);

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

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function search(Request $request)
    {
        $validator = $this->searchFilterValidation($request);

        if ($validator) {
            return redirect($this->dataAssign['module']);;
        }

        $current_user = Auth()->user();

        $widgets = $this->widget_model->where('id', $request->type)->get();

        $this->dataAssign['widget'] = $this->widget_model->getQueryResult($widgets);

        $this->dataAssign['show_in_dashboard'] = $this->widget_user_model->checkUserWidgets($this->dataAssign['widget']);

        $this->dataAssign['listing_data'] = $this->widget_model->getListingData($this->dataAssign['widget']);

        $this->dataAssign['graph_data'] = $this->widget_model->getGraphData($this->dataAssign['widget']);

        $this->dataAssign['types'] = $this->widget_model->getWidgetsForReports($current_user);

        $request->session()->put('search_report', $request->all());

        $this->dataAssign['search_report'] = app('session')->get('search_report');

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.show', $this->dataAssign);
    }

    private function searchFilterValidation($request)
    {
        $validation_error = false;

        if (!$request->filled('type')) {
            flash('Please Select Report Type', 'danger');

            $request->session()->forget('search_report');

            $validation_error = true;
        }

        return $validation_error;
    }

    public function routeListingArray($search)
    {
        return [
            'route' => $this->dataAssign['module'] . '.ajaxListing',
            'key' => 'search_by',
            'value' => $search
        ];
    }

    public function export($type)
    {
        $report_type = app('session')->get('search_report');
        if (app('session')->has('search_report')) {

            return $this->seach_filter_repo->export($type, $report_type);
        }

        flash('Please Select Report First', 'danger');

        return redirect($this->dataAssign['module']);
    }

    protected function ajaxListing()
    {
        $search_by = app('request')->get('search_by');

        $data = $this->seach_filter_repo->reportFilterData($search_by);

        $actions = [];

        $module = $this->dataAssign['module'];

        return $this->makeDataTable($data, $actions, $module);
    }

    public function showInDashboard(Request $request)
    {
        $this->widget_user_model->store($request->all());

    }
}
