<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestUser extends Mailable
{
    use Queueable, SerializesModels;

    public $event, $mail, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $request, $user)
    {
        $this->event = $event;
        $this->mail = $request;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mail->subject)->view('emails.request-user');
    }
}
