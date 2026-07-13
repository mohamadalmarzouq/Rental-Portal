<?php

namespace App\Exports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UnitVacancyReportExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $unit_model = new Unit;

        return $unit_model->getReportData(Auth()->user())->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Unit Number',
            'Unit Size',
            'Property Name',
            'Type',
            'No of bedrooms',
            'No of bathrooms',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($unit): array
    {
        return [
            $unit->number,
            $unit->size,
            $unit->property->name,
            $unit->type,
            $unit->no_of_bedrooms,
            $unit->no_of_bathrooms,
        ];
    }
}
