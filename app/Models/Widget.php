<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Widget extends Model
{
    protected $fillable = ['title', 'icon', 'query', 'module', 'method', 'type_id', 'status_id'];

    protected $appends = ['widget_roles', 'widget_status'];

    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'type.name', 'name' => 'type.name', 'title' => 'Widget Type'],
            ['data' => 'widget_roles', 'name' => 'widget_roles', 'title' => 'Access Roles', 'searchable' => 'false'],
            ['data' => 'widget_status', 'name' => 'widget_status', 'title' => 'Widget Status', 'searchable' => 'false'],
            ['data' => 'action', 'name' => 'Actions', 'searchable' => 'false'],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false]
        ];

        return json_encode($data);
    }

    public function getWidgetStatusAttribute()
    {
        $status = $this->status->slug;

        $status_name = $this->status->status;

        return View::make('panel.includes.status_mutator', compact('status', 'status_name'))->render();
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function getWidgetRolesAttribute()
    {
        $access = $this->find($this->id)->roles()->get();

        $access_array = [];

        foreach ($access as $access_role) {
            $access_array[] = $access_role->name;
        }

        return implode(', ', $access_array);
    }

    public function getWidgetTypeAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->slug));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'widgets_roles', 'widget_id');
    }

    public function widgetRoles()
    {

        return $this->hasMany(WidgetsRole::class, 'widget_id', 'id');
    }

    public function widgetUser()
    {

        return $this->hasMany(WidgetUser::class, 'widget_id', 'id');
    }

    public function getWidgets($current_user)
    {
        $query = $this->whereHas('widgetRoles', function ($q) use ($current_user) {
            $q->where('role_id', $current_user->role_id);
        });

        if (!in_array($current_user->role_id, $current_user->getSuperAdminRoleIds())) {
            $query = $query->whereHas('widgetUser', function ($q) use ($current_user) {
                $q->where('user_id', $current_user->id);
            });
        }

        $query = $query->orderByRaw('sorting + 0 asc')->whereHas('status', function ($q) {
            $q->where('slug', 'active');
        });
        return $query->get();
    }

    public function getWidgetsForReports($current_user)
    {
        $query = $this->whereHas('widgetRoles', function ($q) use ($current_user) {
            $q->where('role_id', $current_user->role_id);
        });

        $query = $query->orderByRaw('sorting + 0 asc')->whereHas('status', function ($q) {
            $q->where('slug', 'active');
        });

        return $query->get();
    }

    public function getQueryResult($widgets)
    {

        foreach ($widgets as $key => $widget) {
            if (isset($widget->query)) {
                $widget->query = $this->parseWidgetQuery($widget->query);
                $widget->query = DB::select($widget->query);
            }
        }
        return $widgets;
    }

    public function parseWidgetQuery($query)
    {
        $new_query = '';
        $request_params = app('request')->all();

        $replacers = [
            '[USER_ID]' => Auth::user()->id,
            '[USER_ROLE]' => Auth::user()->role_id,
            '[PROPERTY]' => isset($request_params['property']) ? $request_params['property'] : 'null',
            '[START_DATE]' => $this->startDate('start_date'),
            '[END_DATE]' => $this->endDate('end_date')
        ];

        foreach ($replacers as $key => $replacer) {
            $new_query = str_replace($key, $replacer, $query);
            $query = $new_query;
        }
        // dd($new_query);
        return $new_query;
    }

    public function startDate($date){
        $request_params = app('request')->all();
        $require = isset($request_params[$date]) ? $request_params[$date] : '';
        if (!$require) {

            $require = date("Y-m-d", strtotime("1990 January 1st"));
            return "'".$require."'";
        }
        return "'".$require."'";
    }
    public function endDate($date){
        $request_params = app('request')->all();
        $require = isset($request_params[$date]) ? $request_params[$date] : '';

        if (!$require) {

            $require = date("Y-m-d", strtotime("this year December 31st"));
            return "'".$require."'";
        }
        return "'".$require."'";
    }

    public function getListingData($widgets)
    {
        $listing_data = [];

        foreach ($widgets as $key => $widget) {

            if ($widget->type->slug == 'table' || $widget->type->slug == 'single_table') {

                $controller = config('filesystems.FULL_PANEL_CONTROLLER_PATH') . ucfirst($widget->module) . 'Controller';

                $class = new $controller(Request::create('', 'GET'));

                $widget->listing_data = json_decode($class->{$widget->method}());

                $listing_data[] = $widget;
            }
        }

        return $listing_data;
    }

    public function getGraphData($widgets)
    {
        $graph_data = [];

        foreach ($widgets as $key => $widget) {

            if ($widget->type->slug == 'flot_line_chart' ||
                $widget->type->slug == 'pie_chart' ||
                $widget->type->slug == 'barometer' ||
                $widget->type->slug == 'flot_bar_chart') {

                $controller = config('filesystems.FULL_PANEL_CONTROLLER_PATH') . ucfirst($widget->module) . 'Controller';

                $class = new $controller(Request::create('', 'GET'));

                $widget->graph_data = json_decode($class->{$widget->method}());

                $graph_data[] = $widget;
            }
        }

        // dd($graph_data);
        return $graph_data;
    }

    public function showInDashboard($widget)
    {
        $status_model = new Status();

        $status_id = $status_model->getStatusID($this->getTable(), 'active');

        if ($widget[0]->status_id == $status_id) {
            return true;
        }

        return false;
    }

    public function updateWidgetStatus($request)
    {
        $status_model = new Status();

        if ($request['show']) {

            $status_id = $status_model->getStatusID($this->getTable(), 'active');
        } else {
            $status_id = $status_model->getStatusID($this->getTable(), 'in-active');
        }

        $this->findOrFail($request['widget_id'])->update(['status_id' => $status_id]);
    }
}
