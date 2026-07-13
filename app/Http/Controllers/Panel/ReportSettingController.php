<?php

namespace App\Http\Controllers\Panel;

use App\Models\ReportSetting;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportSettingController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new ReportSetting();
        $this->type_model = new Type();
        $this->dataAssign['module'] = 'report_settings';
        $this->dataAssign['actions'] = ['edit_report', 'view_report'];
        $this->show_toggle_in_list[] = ['column_name' => 'enable_report', 'column_data' => 'enable_report', 'update_url' => route($this->dataAssign['module'] . '.enable_report')];
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';
        $this->dataAssign['data_table_columns'] = $this->type_model->getColumnsForDataTable();
    }

    public function show()
    {
        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function add(Request $request)
    {
        $current_user = Auth()->user();

        $this->dataAssign['data'] = $this->primary_model->where('report_type_id', $request->report_id)
            ->where('land_lord_id', $current_user->id)->first();

        $this->dataAssign['report_id'] = $request->report_id;

        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    public function store(Request $request)
    {
        $this->primary_model->scheduleDateReports($request->all());
    }

    public function enableReport(Request $request)
    {
        $this->primary_model->enableDisableReports($request->all());

        return back();
    }

    protected function ajaxListing()
    {
        $data = $this->type_model->reportSettingAjaxListing();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        return $this->makeDataTable($data, $actions, $module);
    }
}
