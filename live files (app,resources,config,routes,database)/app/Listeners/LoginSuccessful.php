<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LoginSuccessful
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $event->subject = 'Login';
        $event->description = 'User logged in successfully';
        activity($event->subject)
            ->causedBy($event->user)
            ->withProperties(['ip' => request()->ip()])
            ->log($event->description);
    }
}
