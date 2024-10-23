<?php

namespace App\Listeners;

use App\Events\Notify;
use App\Mail\Notification;
use Illuminate\Support\Facades\Mail;

class UserRegisterNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Notify $event): void
    {
        Mail::to($event->user->email)->send(new Notification($event->user, (object)[
            'subject' => $event->params->subject,
            'view' => $event->params->view,
            'attachments' => $event->params->attachments,
            'data' => $event->params->data,
        ]));
    }
}
