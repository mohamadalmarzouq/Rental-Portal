<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenant extends FormRequest
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
            'contact_number' => 'required|regex:/[0-9]{7}/ |max:7',
            'email' => 'nullable|email|unique:tenants,email',
            'age' => 'nullable|numeric|min:0',
            'national_id' => 'required',
            'gender' => 'nullable|in:male,female',
        ];
    }

    public function prepareForValidation()
    {
        $current_user = Auth()->user();

        $this->merge(['creator_id' => $current_user->id]);
    }
}
