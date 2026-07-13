<?php

namespace App\Listeners;

use App\Models\Notification;

class NotifyLandLordAccountApproved
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->notification_model = new Notification();
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        //insert team header in notification table
        $notification = $this->notification_model->create([
            'identifier' => 'land_lord_approved',
            'module' => 'users',
            'ref_id' => $event->user->id,
            'receiver' => $event->user->id,
            'sender' => Auth()->user()->id,
            'replacers' => implode(',', [Auth()->user()->name])
        ]);

        $title = 'Rent Portal Account Approved';

        //send mail
        $this->notification_model->sendMail($event->user->id, $notification,$title);
    }
}
