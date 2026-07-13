<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoiceExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $invoice_model = new Invoice;

        return $invoice_model->ajaxListing()->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'ID',
            'Type Name',
            'Tenant Name',
            'Property Name',
            'Unit',
            'Duration',
            'Amount',
            'Unit Status',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->type->name,
            $invoice->tenant->name,
            $invoice->property->name,
            $invoice->unit->number,
            $invoice->duration,
            $invoice->amount,
            $invoice->status->status,
        ];
    }
}
