<?php

namespace App\Events;

use App\Models\Invoice;
use Illuminate\Queue\SerializesModels;

class MarkInvoice
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        //
        $this->invoice = $invoice;
    }

}
