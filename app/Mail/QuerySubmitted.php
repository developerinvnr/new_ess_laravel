<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuerySubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $queryData;

    public function __construct(array $queryData)
    {
        $this->queryData = $queryData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Query Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.querysubmit', // Make sure this matches your view file
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

