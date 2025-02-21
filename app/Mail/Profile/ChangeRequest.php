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
                 ->subject($this->details['subject'])
                 ->markdown('mail.profile.change-request')
                 ->with('details', $this->details);
    
    // Attach files if any
    if (!empty($this->details['attachments'])) {
        foreach ($this->details['attachments'] as $attachment) {
            $mail->attach($attachment);
        }
    }

    return $mail;
    }
}

