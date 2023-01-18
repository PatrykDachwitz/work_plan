<?php

namespace App\Listener;

use App\Event\ActualizationGroupNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendGroupNotification
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
     * @param  \App\Event\ActualizationGroupNotification  $event
     * @return void
     */
    public function handle(ActualizationGroupNotification $event)
    {
        foreach ($event->notifications as $notification) {
            Log::info("xzy -> {$notification->description} {$notification->created_at}");
        }
    }
}
