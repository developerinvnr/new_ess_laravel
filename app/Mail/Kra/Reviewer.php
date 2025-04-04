<?php

namespace App\Mail\Kra;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

class Reviewer extends Mailable
{

    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

public function build(){
    return $this->from('webadmin@vnrseeds.com','Webadmin')
                ->subject($this->details['subject'])
                ->markdown('mail.KRA.Reviewer')
                ->with('details',$this->details);
}
}
