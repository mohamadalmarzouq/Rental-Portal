<?php

namespace App\Http\Requests\Lease;

use App\Rules\TenantRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLease extends FormRequest
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
            'property_id' => 'required|exists:properties,id',
            'type_id' => 'required|exists:types,id',

            'frequency_id' => 'required|exists:types,id',
            'monthly_rent' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount' => 'nullable|numeric',
            'advance_payment' => 'nullable|numeric',
            'waived_amount' => 'nullable|numeric',
            'unit_id'=>'required',
            'residence_type'=>'required'

        ];

        $rules['tenant_id'] = ['required','exists:tenants,id',new TenantRule()];

        if ($this->request->get('enable_notifications') && $this->request->get('enable_notifications')==1) {

            $rules['notification'] = 'required';
        }
        if($this->request->has('deposit')){
            $rules['deposit'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'end_date.after_or_equal' => 'The due date must be a date after or equal to start date.',
            'status_box'=>'Nahi mil rahi.'
        ];
    }

    public function prepareForValidation()
    {
        removeCommaForNumeric($this, ['amount', 'amount_payable', 'monthly_rent', 'waived_amount', 'advance_payment']);
    }
}
