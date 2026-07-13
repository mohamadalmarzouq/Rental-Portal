<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoice extends FormRequest
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
            'start_date' => 'required|date',
        ];

        if ($this->request->has('total_amount')) {
            $rules['total_amount'] = 'required|numeric';
        }


        return $rules;
    }

    public function prepareForValidation()
    {
        if ($this->request->has('extras')) {

            removeCommaForNumericInArray($this, 'extras', ['amount']);

        }

        removeCommaForNumeric($this, ['total_amount']);
    }

    public function messages()
    {
        $message = [];

        if ($this->request->has('extras')) {

            foreach ($this->extras as $key => $extra) {

                $message['extras.' . $key . '.amount.required'] = 'The amount field is required.';

                $message['extras.' . $key . '.amount.numeric'] = 'The amount format is invalid.';

            }
        }

        return $message;
    }
}
