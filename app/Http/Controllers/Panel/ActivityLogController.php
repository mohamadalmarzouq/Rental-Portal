<?php

namespace App\Http\Controllers\Panel;

use App\Models\ActivityLog;
use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->primary_model = new ActivityLog();
        $this->dataAssign['module'] = 'activity_logs';
        $this->dataAssign['actions'] = [];
        $this->dataAssign['route_name_for_listing'] = $this->dataAssign['module'] . '.ajaxListing';
        $this->show_column_url_in_list[] = ['column_name' => 'description', 'actions' => $this->dataAssign['actions']];
        $this->dataAssign['data_table_columns'] = $this->primary_model->getColumnsForDataTable();
    }

    public function show()
    {
        return view($this->layout_base . '.' . $this->dataAssign['module'] . '.' . __FUNCTION__, $this->dataAssign);
    }

    protected function ajaxListing()
    {
        $data = $this->primary_model->ajaxListing();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        return $this->makeDataTable($data, $actions, $module);
    }
}
