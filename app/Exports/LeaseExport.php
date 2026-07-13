<?php

namespace App\Exports;

use App\Models\Lease;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeaseExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $lease_model = new Lease;

        return $lease_model->ajaxListing()->get();
    }

    public function map($lease): array
    {
        return [
            $lease->id,
            $lease->tenant->name,
            $lease->property->name,
            $lease->unit->number,
            $lease->type->name,
            $lease->type_id == 3 ? $lease->rental : '-',
            $lease->pending_amount,
            $lease->lease_payable,
            addCommaForNumeric($lease->advance_payment),
            addCommaForNumeric($lease->waived_amount),
            $lease->frequency->name,
            addCommaForNumeric($lease->monthly_rent),
            $lease->start_date,
            $lease->end_date,
            $lease->description,
            $lease->status->status,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tenant Name',
            'Property Name',
            'Unit',
            'Type',
            'Rental',
            'Pending Amount',
            'Lease Payable',
            'Advance Payment',
            'Total Waived amount',
            'Frequency',
            'Monthly Rent',
            'Lease Start Date',
            'Lease End Date',
            'Description',
            'Lease Status',
        ];
    }
}
