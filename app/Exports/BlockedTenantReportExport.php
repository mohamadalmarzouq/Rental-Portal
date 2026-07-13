<?php

namespace App\Exports;

use App\Models\Tenant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BlockedTenantReportExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $tenant_model = new Tenant;

        return $tenant_model->getBlockedTenantsForReports(Auth()->user())->get();
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
            'Tenant Status'
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
            $tenant->status->status,
        ];
    }
}
