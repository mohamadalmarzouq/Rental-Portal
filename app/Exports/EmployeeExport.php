<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user_model = new User();

        return $user_model->employeesAjaxListing()->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'User Name',
            'User Role',
            'User Email ID',
            'User status'
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($user): array
    {
        return [
            $user->name,
            $user->role->name,
            $user->email,
            $user->status->status,
        ];
    }
}
