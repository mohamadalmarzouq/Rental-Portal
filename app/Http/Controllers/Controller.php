<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $layout_base = 'panel';
    protected $buttons_view = 'includes.datatables_row_buttons';
    protected $actions = ['add', 'edit', 'delete'];
    protected $toggle_view = 'includes.toggle_view';
    protected $image_view = 'includes.image_view';
    protected $url_view = 'includes.url_view';
    protected $show_toggle_in_list = [];
    protected $show_image_in_list = [];
    protected $rawColumns = ['action'];
    protected $hasManualSearch = [];
    protected $show_column_url_in_list = [];

    protected function ajaxListing()
    {
        $data = $this->primary_model::query();

        $actions = $this->dataAssign['actions'];

        $module = $this->dataAssign['module'];

        return $this->makeDataTable($data, $actions, $module);
    }

    final function makeDataTable($data, $actions, $module, $is_order = false,$order_column = '',$order_array = [])
    {

        $buttons = empty($this->makeCustomActionButtonsForNestedTables)
            ? $this->makeCustomActionButtons($module)
            : $this->makeCustomActionButtonsForNestedTables;

        $buttons_view = $this->buttons_view;

        $data_table = Datatables::of($data)->order(function ($query) use ($is_order,$order_column,$order_array) {

            if (request()->draw != '1' && $is_order) {
                !empty($order_array) ? $this->manualOrdering($query, $order_array) : $this->manualOrdering($query);
            } else {
                $query->orderBy($order_column ? $order_column : 'created_at', 'desc');
            }

        })->editColumn('status', function ($row) {

            return ucwords(str_replace("-", " ", $row->status));

        })->addColumn('action', function ($row) use ($actions, $module, $buttons, $buttons_view) {

            return View::make($this->layout_base . '.' . $buttons_view, compact('buttons', 'actions', 'module', 'row'))->render();

        });

    /*    $data_table = Datatables::of($data)->order(function ($query) use ($is_order) {

            if (request()->draw != '1' && $is_order) {
                !empty($order_array) ? $this->manualOrdering($query, $order_array) : $this->manualOrdering($query);
            } else {
                $query->orderBy('created_at', 'desc');
            }

        })->editColumn('status', function ($row) {

            return ucwords(str_replace("-", " ", $row->status));

        });

        if($module == 'property'){

        }*/

        //show toggle in datatable
        if (!empty($this->show_toggle_in_list)) {

            $toggle_view = $this->toggle_view;

            foreach ($this->show_toggle_in_list as $toggle_column) {

                $data_table->addColumn($toggle_column['column_name'], function ($row) use ($toggle_column, $toggle_view) {

                    return View::make($this->layout_base . '.' . $toggle_view, compact('row', 'toggle_column'))->render();

                });

                $this->rawColumns[] = $toggle_column['column_name'];
            }
        }

        if (!empty($this->show_image_in_list)) {

            $image_view = $this->image_view;

            foreach ($this->show_image_in_list as $image_column) {

                $data_table->addColumn($image_column['column_name'], function ($row) use ($image_column, $image_view) {

                    $image_path = getUserAvatar($row->id);

                    return View::make($this->layout_base . '.' . $image_view, compact('image_path'))->render();

                });

                $this->rawColumns[] = $image_column['column_name'];
            }
        }

        if (!empty($this->show_column_url_in_list)) {

            $column_url_view = $this->url_view;
            foreach ($this->show_column_url_in_list as $url_column) {
                $data_table->editColumn($url_column['column_name'], function ($row) use ($url_column, $column_url_view) {

                    $text = $row->{$url_column['column_name']};

                    $url_column['route_name'] = $row->module;

                    $id = $row->subject_id;

                    $actions = $url_column['actions'];

                    return View::make($this->layout_base . '.' . $column_url_view, compact('id', 'text', 'url_column',
                        'actions'))->render();

                });

                $this->rawColumns[] = $url_column['column_name'];
            }

        }


        if (!empty($this->hasManualSearch)) {

            $model = $this->hasManualSearch['model'];

            $data_table->filter(function ($query) use ($model) {

                return $model->manualSearch($query);
            });
        }

        return $data_table->rawColumns($this->rawColumns)->make(true);

    }

    protected function makeCustomActionButtons($module)
    {
        return [
            'edit' => ['route' => $module . '.edit'],
            'delete' => ['route' => $module . '.delete'],
            'view' => ['route' => $module . '.view']
        ];
    }

    public function manualOrdering(&$query, $order_array = [])
    {
        $array = !empty($order_array) ? $order_array : $this->primary_model->orderArray();

        $order_column = request()->order[0];

        $column_no_to_sort = $order_column['column'];

        if ($array[$column_no_to_sort]['order']) {

            if (!empty($array[$column_no_to_sort]['relationship'])) {

                $query->orderByJoin($array[$column_no_to_sort]['name'], $order_column['dir']);

            } else {
                $query->orderBy($array[$column_no_to_sort]['name'], $order_column['dir']);
            }

        } else {
            $query->orderBy('created_at', 'desc');
        }
    }

}
