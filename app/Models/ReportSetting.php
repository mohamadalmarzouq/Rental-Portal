<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ReportSetting extends Model
{
    protected $fillable = ['report_type_id', 'land_lord_id', 'enable', 'schedule_date', 'schedule_time'];

    public function type()
    {
        return $this->belongsTo(Type::class, 'report_type_id');
    }

    public function land_lord()
    {
        return $this->belongsTo(User::class, 'land_lord_id');
    }

    public function scheduleDateReports($request)
    {
        $data = $this->where('report_type_id', $request['report_id'])
            ->where('land_lord_id', $request['user_id']);

        if ($data->count()) {

            $data = $data->first();

            $schedule_date = $data->schedule_date;
            $schedule_time = $data->schedule_time;
            $is_enable = $data->enable;

            $data->delete();
        } else {

            $is_enable = 1;
            $schedule_date = '';
            $schedule_time = '';
        }

        if (isset($request['schedule_date'])) {
            $schedule_date = $request['schedule_date'];
        }

        if (isset($request['schedule_time'])) {
            $schedule_time = $request['schedule_time'];
        }

        $this->create(
            [
                'report_type_id' => $request['report_id'],
                'land_lord_id' => $request['user_id'],
                'enable' => $is_enable,
                'schedule_date' => $schedule_date,
                'schedule_time' => $schedule_time
            ]
        );
    }

    public function enableDisableReports($request)
    {
        $data = $this->where('report_type_id', $request['report_id'])
            ->where('land_lord_id', $request['user_id']);

        if ($data->count()) {

            $data = $data->first();

            if ($data->enable) {

                $is_enable = 0;
            } else {

                $is_enable = 1;
            }
            $schedule_date = $data->schedule_date;
            $schedule_time = $data->schedule_time;
            $data->delete();
        } else {
            $schedule_date = null;
            $schedule_time = null;
            $is_enable = 1;
        }

        $this->create(
            [
                'report_type_id' => $request['report_id'],
                'land_lord_id' => $request['user_id'],
                'enable' => $is_enable,
                'schedule_date' => $schedule_date,
                'schedule_time' => $schedule_time
            ]
        );
    }
}
