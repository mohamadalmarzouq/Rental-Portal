<?php

namespace App\Exports;

use App\Models\Property;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PropertyExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $property_model = new Property;

        return $property_model->ajaxListing()->get();
    }

    public function map($property): array
    {
        return [
            $property->id,
            $property->name,
            $property->type->name,
            $property->paci_id,
            $property->countries->country_name,
            $property->address,
            !$property->occupied_units ? '0' : $property->occupied_units,
            !$property->vacant_units ? '0' : $property->vacant_units,
            !$property->total_units ? '0' : $property->total_units,
            $property->status->status,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Type',
            'PACI ID',
            'Country',
            'Address',
            'Occupied Units',
            'Vacant Units',
            'Total Units',
            'Status',
        ];
    }
}
