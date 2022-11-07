<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessagePostMail extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg,$user)
    {
        $this->msg = $msg;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.message_mail')
            ->subject('test mail');
    }
}
