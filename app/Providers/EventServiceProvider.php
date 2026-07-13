<?php

namespace App\Providers;

use App\Events\ForgotPasswordMail;
use App\Events\LandLordAccountApproved;
use App\Events\LandLordSignUp;
use App\Events\MarkInvoice;
use App\Events\VerificationMail;
use App\Listeners\NotifyLandLordAccountApproved;
use App\Listeners\NotifyLandLordSignUp;
use App\Listeners\NotifyMarkedInvoice;
use App\Listeners\NotifyVerificationMail;
use App\Listeners\VerifyForgotPasswordMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MarkInvoice::class => [
            NotifyMarkedInvoice::class
        ],
        VerificationMail::class => [
            NotifyVerificationMail::class
        ],
        LandLordSignUp::class => [
            NotifyLandLordSignUp::class
        ],
        LandLordAccountApproved::class => [
            NotifyLandLordAccountApproved::class
        ],
        ForgotPasswordMail::class => [
            VerifyForgotPasswordMail::class
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
