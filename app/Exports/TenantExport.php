<?php

namespace App\Exports;

use App\Models\Tenant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TenantExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $tenant_model = new Tenant();

        return $tenant_model->ajaxListing()->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Contact Number',
            'Email ID',
            'National ID',
            'Age',
            'Gender',
            'Residence Type',
            'Tenant Status',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($tenant): array
    {
        return [
            $tenant->id,
            $tenant->name,
            $tenant->contact_number,
            $tenant->email,
            $tenant->national_id,
            $tenant->age,
            $tenant->gender,
            $tenant->type ? $tenant->type->name : 'N/A',
            $tenant->status->status,
        ];
    }
}
