<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTenant extends FormRequest
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
            'name' => 'required',
            'contact_number' => 'required|regex:/[0-9]{7}/|max:7',
            'email' => 'required|email|unique:tenants,email,' . $this->id,
            'age' => 'required|numeric|min:0',
            'gender' => 'required|in:male,female',
        ];
    }
}
