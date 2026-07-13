<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::with('role')->get();
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
            'Properties assigned',
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
            $user->properties_assigned,
            $user->status->status,
        ];
    }
}
