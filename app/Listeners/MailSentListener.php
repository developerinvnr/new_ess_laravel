<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Events\MessageSent;

class MailSentListener
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
    public function handle(MessageSent $event)
    {
        // Get the recipients from the message
        $recipients = $event->message->getTo();

        // Format the recipients as a comma-separated string
        $recipientEmails = implode(', ', array_keys($recipients));

        // Log the recipient emails
        \Log::info('Email sent to: ' . $recipientEmails);
    }
}
