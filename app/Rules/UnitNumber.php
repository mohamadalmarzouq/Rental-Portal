<?php

namespace App\Rules;

use App\Models\Unit;
use Illuminate\Contracts\Validation\Rule;

class UnitNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $property_id;
    private $unit_id;
    private $unit;
    private $key;


    public function __construct($property_id,$unit_id,$unit,$key)
    {
        //
        $this->unit_id = $unit_id;
        $this->property_id = $property_id;
        $this->unit = $unit;
        $this->key = $key;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //

        $unit = Unit::where('property_id',$this->property_id)->where('number',$value)->first();
        //$unit = Unit::where('property_id',$this->property_id)->where('number',$value)->get();
        if($this->unit_id =="0"){

            if(empty($unit)){

                return true;
            }
            else{
                return false;
            }

        }

        else{
            $count = Unit::find($this->unit_id);
            $id = isset($count->id)?$count->id:'';
            $counter = 0;
            if(empty($unit) || $id == $unit->id){
                foreach($this->unit as $key=>$valuee){
                    if($valuee['number'] == $this->unit[$this->key]['number']){
                        $counter++;
                    }
                }
                if($counter > 1){
                    return false;
                }
                return true;
            }
            else{

                return false;
            }

        }

            }










    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This field must be Unique.';
    }
}
