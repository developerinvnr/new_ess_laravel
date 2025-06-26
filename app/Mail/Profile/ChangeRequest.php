<?php

namespace App\Mail\Profile;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $mail = $this->from('webadmin@vnrseeds.com', 'Webadmin')
                ->subject($this->details['subject'] ?? 'Change Request')
                 ->markdown('mail.profile.change-request')
                 ->with('details', $this->details);
    
    if (!empty($this->details['attachments'])) {
        foreach ($this->details['attachments'] as $attachment) {
            $mail->attachFromStorageDisk('s3', $attachment);
        }
    }

    return $mail;
    }
}

