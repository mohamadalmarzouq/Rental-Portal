<?php

namespace App\Listeners;

use App\User;

class VerifyForgotPasswordMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user_model = new User();
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $body = '<p>Click the link below to reset your password:</p>';
        $body .= '<p><a href="' . url('reset-password?token=' . $event->user->remember_token . '&email=' . $event->user->email) . '">Reset Password</a></p>';

        $this->user_model->sendMail($event->user, $body);
    }
}
