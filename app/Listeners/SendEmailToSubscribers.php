<?php

namespace App\Listeners;

use App\Events\NewPostCreated;
use App\Notifications\NewPostNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEmailToSubscribers implements ShouldQueue
{
    use Queueable;

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
    public function handle(NewPostCreated $event): void
    {
        $subscribers = $event->user->subscribers;

        if(!($subscribers->isEmpty())){
            Notification::send($subscribers, new NewPostNotification($event->user, $event->post));
        }
    }
}
