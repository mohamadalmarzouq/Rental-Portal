<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'user_status_id' => 'required|exists:statuses,id',
            'password' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $current_user = Auth()->user();

        $this->merge(['creator_id' => $current_user->id,'role_id' => config('role-ids.employee_role_id')]);
    }
}
