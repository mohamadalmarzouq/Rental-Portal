<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpense extends FormRequest
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
            'type_id' => 'required|exists:types,id',
            'expense_property_id' => 'required|exists:properties,id',
            'date_start_expense' => 'required|date',
            'expense_amount' => 'required|numeric',
        ];
    }

    public function prepareForValidation()
    {
        removeCommaForNumeric($this, ['expense_amount']);
    }

    public function messages()
    {
        $message['date_start_expense.required'] = 'The date field is required.';

        $message['date_start_expense.date'] = 'The selected date is invalid.';

        $message['expense_property_id.required'] = 'The property field is required.';

        $message['expense_amount.required'] = 'The amount field is required.';

        return $message;
    }
}
