<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $appends = ['schedule_date_report', 'schedule_time_report'];

    public function getColumnsForDataTable()
    {
        $data = [
            ['data' => 'name', 'name' => 'name', 'title' => 'Report Type'],
            ['data' => 'enable_report', 'name' => 'enable_report', 'title' => 'Report Enable'],
            ['data' => 'schedule_date_report', 'name' => 'schedule_date_report', 'title' => 'Schedule Date'],
            ['data' => 'schedule_time_report', 'name' => 'schedule_time_report', 'title' => 'Schedule Time'],
            ['data' => 'action', 'name' => 'Action', 'searchable' => 'false'],
        ];

        return json_encode($data);
    }

    public function getScheduleDateReportAttribute()
    {
        return isset($this->report_settings->schedule_date) ? $this->report_settings->schedule_date : '';
    }

    public function getScheduleTimeReportAttribute()
    {
        return isset($this->report_settings->schedule_time) ? $this->report_settings->schedule_time : '';
    }

    public function getPropertyTypes()
    {
        return $this->where('module', 'properties')->get();
    }

    public function getLeaseTypes()
    {
        return $this->where('module', 'leases')->get();
    }

    public function getLeaseFrequencyTypes()
    {
        return $this->where('module', 'frequency')->get();
    }

    public function getInvoiceTypes()
    {
        return $this->where('module', 'invoices')->get();
    }

    public function getTenantTypes()
    {
        return $this->where('module', 'tenants')->get();
    }

    public function getReportTypes()
    {
        $current_user = Auth()->user();

        return $this->where('module', 'reports')->WhereHas('report_settings', function ($q) use ($current_user) {

            $q->where('enable', 1);

            $q->where('land_lord_id', $current_user->id);

            $q->orWhere('land_lord_id', $current_user->creator_id);
        })->get();
    }

    public function getWidgetTypes()
    {
        return $this->where('module', 'widgets')->get();
    }

    public function getTypeId($module, $slug)
    {
        return $this->where('module', $module)->where('slug', $slug)->first()->id;
    }

    public function report_settings()
    {
        return $this->hasOne(ReportSetting::class, 'report_type_id');
    }

    public function reportSettingAjaxListing()
    {
        $current_user = Auth()->user();

        return $this->with(['report_settings'])
            ->where('module', 'reports')
            ->orWhereHas('report_settings', function ($q) use ($current_user) {
                $q->where('land_lord_id', $current_user->id);
                $q->orWhere('land_lord_id', $current_user->creator_id);
            });
    }
}
