<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoice extends FormRequest
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
        $rules = [
            'type_id' => 'required|exists:types,id',
            // 'property_id' => 'required|exists:properties,id',
            // 'unit_id' => 'required|exists:units,id',
            'revenue_start_date' => 'required|date',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ];

        if ($this->request->has('lease_id')) {
            $rules['lease_id'] = 'required';
        }

        if ($this->request->has('total_amount')) {
            $rules['total_amount'] = 'required|numeric';
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        removeCommaForNumeric($this, ['total_amount']);
    }

    public function messages()
    {
        return [
            'revenue_start_date.required' => 'Invoice date is required'
        ];

    }
}
