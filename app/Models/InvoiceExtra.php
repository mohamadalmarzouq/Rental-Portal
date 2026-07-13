<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class InvoiceExtra extends Model
{
    protected $fillable = ['is_lease', 'amount', 'invoice_id', 'lease_id', 'tenant_id', 'unit_id', 'property_id', 'waive_amount'];


    public function attachItems($extra, $invoice_id)
    {

        $total_amount   =   str_replace(",", "", $extra['total_amount']) ?? 0;
        $total_amount   =   intval($total_amount);

        $this->create(
            [
                'is_lease' => $extra['is_lease'],
                'lease_id' => $extra['lease_id'] ?? null,
                'tenant_id' => $extra['tenant_id'] ?? null,
                'unit_id' => $extra['unit_id'] ?? null,
                'property_id' => $extra['property_id'] ?? null,
                'amount' => $total_amount ?? null,
                'waive_amount' => $extra['waive_amount'] ?? null,
                'invoice_id' => $invoice_id,
            ]
        );

        return $total_amount;
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

}
