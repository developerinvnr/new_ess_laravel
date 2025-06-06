<?php

namespace App\Mail\Query;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

class Querytoqueryowner extends Mailable
{

    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

public function build(){
    return $this->from('webadmin@vnrseeds.com','Webadmin')
                ->subject($this->details['subject'])
                ->markdown('mail.query.query-to-queryowner')
                ->with('details',$this->details);
}
}
