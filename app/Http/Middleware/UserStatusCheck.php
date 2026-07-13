<?php

namespace App\Http\Middleware;

use App\Models\Status;
use Closure;

class UserStatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth()->check()){

            $status_model = new Status();

            $status_id = $status_model->getStatusID('users','active');

            $user_status_id = Auth()->user()->user_status_id;

            if ($status_id != $user_status_id)
            {
                return response()->view('auth.pending_user');
            }

        }
        return $next($request);
    }
}
