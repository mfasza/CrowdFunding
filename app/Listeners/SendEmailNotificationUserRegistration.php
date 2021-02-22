<?php

namespace App\Listeners;

use App\Events\UserRegistrationEvent;
use App\Mail\Auth\UserRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationUserRegistration implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistrationEvent  $event
     * @return void
     */
    public function handle(UserRegistrationEvent $event)
    {
        Mail::to($event->user)->send(new UserRegistration($event->user));
    }
}
