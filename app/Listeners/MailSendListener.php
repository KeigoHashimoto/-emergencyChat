<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PostedMessage;
use App\Mail\MessagePostMail;
use Mail;

class MailSendListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PostedMessage $event)
    {
        Mail::to($event->users)->send(new MessagePostMail('Helme通知！',$event->user->name));
    }
}
