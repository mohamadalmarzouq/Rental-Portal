<?php

namespace App\Exports;

use App\Models\Lease;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpiringLeaseReportExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $lease_model = new Lease;

        return $lease_model->getExpiringLeaseForReports(Auth()->user())->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'ID',
            'Lease name	',
            'Property Name',
            'Unit',
            'Type',
            'Total Pending Amount',
            'Lease payable',
            'Lease Status',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($lease): array
    {
        return [
            $lease->id,
            $lease->lease_name,
            $lease->property->name,
            $lease->unit->number,
            $lease->type->name,
            $lease->pending_amount,
            $lease->lease_payable,
            $lease->status->status,
        ];
    }
}
