<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProperty extends Model
{
    protected $fillable = ['user_id', 'property_id'];

    public function attachProperties($properties, $id)
    {
        $this->where('user_id', $id)->delete();

        foreach ($properties as $property) {
            $this->create([
                'property_id' => $property,
                'user_id' => $id,
            ]);
        }
    }
}
