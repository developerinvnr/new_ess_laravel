<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogOutListener
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
    public function handle(Logout $event): void
    {
        $event->subject = 'Logout';
        $event->description = 'User logged out successfully';
        activity($event->subject)
            ->causedBy($event->user)
            ->withProperties(['ip' => request()->ip()])
            ->log($event->description);
    }
}
