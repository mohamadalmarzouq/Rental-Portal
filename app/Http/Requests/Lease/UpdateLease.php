<?php

namespace App\Http\Requests\Lease;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLease extends FormRequest
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
            'frequency_id' => 'required|exists:types,id',
            'monthly_rent' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount' => 'nullable|numeric',
            'advance_payment' => 'nullable|numeric',
            'waived_amount' => 'nullable|numeric',
            'lease_status_id' => 'required|exists:statuses,id',


        ];

        if($this->request->get('residence_type')=='residential'){
            $rules['marriage_status']='required';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'end_date.after_or_equal' => 'The due date must be a date after or equal to start date.',
            'marriage_status'=>"This is required",

        ];
      /*  return [

            'end_date.after_or_equal' => 'The due date must be a date after or equal to start date.',

            //'end_date.after_or_equal' => 'The due date must be a date after or equal to start date.'
        ];*/
        return $messages;
    }

    public function prepareForValidation()
    {
        removeCommaForNumeric($this, ['amount', 'amount_payable', 'monthly_rent', 'waived_amount', 'advance_payment']);
    }
}
