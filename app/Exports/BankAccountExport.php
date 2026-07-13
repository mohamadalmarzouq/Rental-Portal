<?php

namespace App\Exports;

use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BankAccountExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BankAccount::where('creator_id',Auth::id())->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Bank Name',
            'Account title',
            'Account number',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($bank_account): array
    {
        return [
            $bank_account->bank_name,
            $bank_account->account_title,
            $bank_account->account_number,
        ];
    }
}
