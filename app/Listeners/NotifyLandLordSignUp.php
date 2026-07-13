<?php

namespace App\Listeners;

use App\Models\Notification;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyLandLordSignUp
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = User::find(config('app.super_admin_id'));
         $land_lords = User::whereHas('role',function($qu){
            $qu->where('slug','land-lord');
         })->get();
         foreach ($land_lords as $key => $land_lord)
         {
           if($land_lord->notification_enable)
           {
                $notification = $this->notification_model->create([
                    'identifier' => 'land_lord_sign_up',
                    'module' => 'users',
                    'ref_id' => $event->user->id,
                    'receiver' => $land_lord->id,
                    'sender' => $event->user->id,
                    'read' => 0,
                    'replacers' => implode(',',[$event->user->name])
                ]);
           }
         }
        if($user->notification_enable)
        {
             //insert team header in notification table
            $notification = $this->notification_model->create([
                'identifier' => 'land_lord_sign_up',
                'module' => 'users',
                'ref_id' => $event->user->id,
                'receiver' => config('app.super_admin_id'),
                'sender' => $event->user->id,
                'read' => 0,
                'replacers' => implode(',',[$event->user->name])
            ]);
        }


        //send mail
        //$this->notification_model->sendMail($event->invoice->project->client->assignedTo->id,$notification);
    }
}
