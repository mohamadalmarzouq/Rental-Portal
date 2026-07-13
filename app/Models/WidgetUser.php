<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetUser extends Model
{
    protected $fillable = ['widget_id', 'user_id'];

    public function store($request)
    {

        if ($request['show']) {

            $this->create([
                'widget_id' => $request['widget_id'],
                'user_id' => auth()->user()->id
            ]);
        } else {
            $this->where('user_id', auth()->user()->id)->where('widget_id', $request['widget_id'])->delete();
        }
    }

    public function checkUserWidgets($widget)
    {

        return $this->where('user_id', auth()->user()->id)->where('widget_id', $widget[0]->id)->count();

    }

    public function showInDashboard($widget_id)
    {
        return $this->where('user_id', auth()->user()->id)->where('widget_id', $widget_id)->count();
    }
}
