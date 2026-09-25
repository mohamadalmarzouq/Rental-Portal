<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function getStatusAttribute($value)
    {
        return tn($value);
    }

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
        $status = $this->where('module', $module)->where('slug', $slug)->first();

        return $status ? $status->id : null;
    }
}
