<?php

namespace App\Listeners;

use App\Models\Notification;
use App\Models\Property;
use App\User;

class NotifyMarkedInvoice
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $property_model = new Property();

        $land_lord_id = $property_model->getAssignedLandlordId($event->invoice->property_id);

        $user = User::find($land_lord_id);

        //insert team header in notification table
        $notification = $this->notification_model->create([
            'identifier' => 'invoice_payment',
            'module' => 'invoices',
            'ref_id' => $event->invoice->id,
            'read' => $user->notification_enable ? 0 : 1,
            'receiver' => $land_lord_id,
            'sender' => Auth()->user()->id,
            'replacers' => implode(',', [Auth()->user()->name, $event->invoice->property->name])
        ]);

        //send mail
        //$this->notification_model->sendMail($event->invoice->project->client->assignedTo->id,$notification);
    }
}
