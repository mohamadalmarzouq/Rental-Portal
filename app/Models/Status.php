<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function getPropertyStatus()
    {
        return $this->where('module', 'properties')->get();
    }

    public function getLeaseStatus()
    {
        return $this->where('module', 'leases')->get();
    }

    public function getInvoiceStatus()
    {
        return $this->where('module', 'invoices')->get();
    }

    public function getTenantStatus()
    {
        return $this->where('module', 'tenants')->get();
    }

    public function getUserStatus()
    {
        return $this->where('module', 'users')->get();
    }

    public function getWidgetStatus()
    {
        return $this->where('module', 'widgets')->get();
    }

    public function getStatusID($module, $slug)
    {
        return $this->where('module', $module)->where('slug', $slug)->first()->id;
    }
}
