<?php

namespace App\Mail\Investment;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

class InvDecMail extends Mailable
{

    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

public function build(){
    return $this->from('webadmin@vnrseeds.com','Webadmin')
                ->subject($this->details['subject'])
                ->markdown('mail.investment.invst-decl-mail')
                ->with('details',$this->details);
}
}
