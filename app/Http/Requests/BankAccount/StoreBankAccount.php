<?php

namespace App\Http\Requests\BankAccount;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankAccount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_name' => 'required',
            'account_title' => 'required',
            'account_number' => 'required|unique:bank_accounts,account_number',
        ];
    }

    public function prepareForValidation()
    {
        $current_user = Auth()->user();

        $this->merge(['creator_id' => $current_user->id]);
    }
}
