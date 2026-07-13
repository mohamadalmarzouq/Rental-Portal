<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\Type;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpenseInvoiceExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $invoice_model = new Invoice;

        $type_model = new Type();

        $expense_type_id = $type_model->getTypeId($invoice_model->getTable(), 'expense');

        return $invoice_model->ajaxListing()->where('type_id', $expense_type_id)->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'ID',
            'Type Name',
            'Property Name',
            'Unit',
            'Payment Method',
            'Tenant Name',
            'Start Date',
            'End Date',
            'Amount',
            'Description',
            'Comment',
            'Status',
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
            $invoice->property->name,
            $invoice->unit->number,
            $invoice->payment_method->name,
            $invoice->tenant->name,
            $invoice->start_date,
            $invoice->end_date,
            $invoice->amount,
            $invoice->description,
            $invoice->comment,
            $invoice->status->status,
        ];
    }
}
