<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public function getPropertyPaymentsMethods()
    {
        return $this->where('module', 'properties')->get();
    }

    public function getLeasePaymentsMethods()
    {
        return $this->where('module', 'leases')->get();
    }

    public function getInvoicePaymentMethods()
    {
        return $this->where('module', 'invoices')->get();
    }

    public function invoicePaymentMethodsForSelect()
    {
        $data = $this->where('module', 'invoices')->get();

        $array = [];

        foreach ($data as $invoice) {
            $array[$invoice->id] = $invoice->name;
        }

        return $array;
    }
}
