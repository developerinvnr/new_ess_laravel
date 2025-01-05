<?php

namespace App\Mail\Leave;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

class LeaveDeleteMail extends Mailable
{

    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

public function build(){
    return $this->from('webadmin@vnrseeds.com','Webadmin')
                ->subject($this->details['subject'])
                ->markdown('mail.leave.leave-delete-mail')
                ->with('details',$this->details);
}
}
