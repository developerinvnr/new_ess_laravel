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

    public $employeeId;
    public $repMgrId;
    public $hodId;
    public $queryValue;
    public $querySubject;

    public function __construct($employeeId, $repMgrId, $hodId, $queryValue, $querySubject)
    {
        $this->employeeId = $employeeId;
        $this->repMgrId = $repMgrId;
        $this->hodId = $hodId;
        $this->queryValue = $queryValue;
        $this->querySubject = $querySubject;
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
    public function build()
    {
        return $this->view('emails.query_submitted')
                    ->with([
                        'employeeId' => $this->employeeId,
                        'repMgrId' => $this->repMgrId,
                        'hodId' => $this->hodId,
                        'queryValue' => $this->queryValue,
                        'querySubject' => $this->querySubject,
                    ]);
    }
    public function attachments(): array
    {
        return [];
    }
}

