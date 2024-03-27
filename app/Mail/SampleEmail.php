<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SampleEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function build()
    {
        return $this->view('emails.sample')
                    ->with(['content' => $this->content])
                    ->subject('Sample Email Subject')
                    ->from('a.allahverdi@icoa.it','Icoa');
                    
    }
}
