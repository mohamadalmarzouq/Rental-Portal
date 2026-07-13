<?php

namespace App\Events;

use App\User;
use Illuminate\Foundation\Events\Dispatchable;

class LandLordSignUp
{
    use Dispatchable;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


}
