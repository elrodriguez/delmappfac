<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $subject, array $contact)
    {
        $this->subject = $subject;
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('layouts.mails.contact');
    }
}
