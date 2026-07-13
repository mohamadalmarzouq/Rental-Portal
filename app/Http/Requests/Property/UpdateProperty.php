<?php

namespace App\Http\Requests\Property;

use App\Models\Unit;
use App\Rules\UnitNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateProperty extends FormRequest
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
            'name' => 'required',
            'address' => 'required',
            'assigned_to' => 'required|exists:users,id',
            'type_id' => 'required|exists:types,id',
            // 'country' => 'required|exists:countries,id',
            'country' => 'required',
            'property_status_id' => 'required|exists:statuses,id',
            'number'=>'unique:units'

        ];

        if ($this->request->get('unit')) {
            foreach ($this->request->get('unit') as $key => $val) {

                foreach ($val as $key1 => $value) {


                    if ($val['type'] != 'residential' && ($key1 == 'no_of_bedrooms' || $key1 == 'no_of_bathrooms' || $key1 == 'no_of_livingrooms' || $key1 == 'no_of_kitchens' || $key1 == 'unit_description' )) {

                    }
                    else if($key1=='number'){
                        //$unit = Unit::where('property_id',$this->id)->get();


                        $unit_id = isset($this->request->get('unit')[$key]['id'])?$this->request->get('unit')[$key]['id']:"0";
                        $rules['unit.'. $key . '.' . $key1 . ''] = ['required',new UnitNumber($this->id,$unit_id,$this->request->get('unit'),$key)];
                    }
                    else {
                        if($key1 != 'unit_description') {
                            $rules['unit.' . $key . '.' . $key1 . ''] = 'required';
                        }
                    }
                }
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];
        if ($this->request->get('unit')) {
            foreach ($this->request->get('unit') as $key => $val) {
                $index = $key == 0 ? '' : $key;
                foreach ($val as $key1 => $value) {
                    if ($val['type'] != 'residential' && ($key1 == 'no_of_bedrooms' || $key1 == 'no_of_bathrooms' || $key1 == 'no_of_livingrooms' || $key1 == 'no_of_kitchens' )) {

                    }

                    else {
                        //$unit = Unit::where('number',$value)->where('property_id',$this->id)->get();


                      //  $messages['unit.' . $key . '.' . $key1 . '.required'] = "This is ".$set;
                        $messages['unit.' . $key . '.' . $key1 . '.unique'] = 'aaa';
                        $messages['unit.' . $key . '.' . $key1 . '.required'] = 'The unit ' . str_replace('_', ' ', $key1) . ' field is required';
                    }
                }
            }
        }
        return $messages;
    }
}
