<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PropertyAssignedMapping extends Model
{
    protected $fillable = ['user_id', 'property_id'];

    public function assignProperties($property_id, $assigned_to)
    {
        $this->where('property_id', $property_id)->delete();

        foreach ($assigned_to as $user_id) {
            $this->create(
                [
                    'user_id' => $user_id,
                    'property_id' => $property_id
                ]
            );
        }
    }
}
