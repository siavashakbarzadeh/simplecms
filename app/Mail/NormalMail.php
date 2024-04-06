<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NormalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $request, $mailer = null)
    {
        if (!is_null($mailer)) $this->mailer($mailer);
        $this->email = $email;
        $this->request = $request;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $envelope = new Envelope(
            subject: array_key_exists('subject',$this->request) && $this->request['subject'] ? $this->request['subject'] : config('app.name'),
        );
        if (array_key_exists('reply_to',$this->request) && $this->request['reply_to']) $envelope->replyTo($this->request['reply_to']);
        return $envelope;
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.normal',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
