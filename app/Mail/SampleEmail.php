<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SampleEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        // You can pass data to the view if needed
    }

    public function build()
    {
        return $this->subject('Sample Email Subject')
                    ->markdown('emails.sample');
    }
}
