<?php

namespace App\Listener;

use App\Event\ActualizationGroupNotification;
use App\Event\AddNotification;
use App\Repository\NotificationRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SendNotification
{
    private $notificationRepository;
    private const COUNT_NOT_READED_NOTIFICATION = 10;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Event\AddNotification  $event
     * @return void
     */

    public function handle(AddNotification $event)
    {
        $data = [
            "description" => $event->comment,
            "readed" => 0,
            "user_id" => $event->user,
            "author_id" => Auth::id(),
            "url_action" => $event->action
        ];

        $filters = [
            'readed' => 0,
            'user_id' => $event->user
        ];

        $this->notificationRepository->create($data);
        $notifications = $this->notificationRepository->get($filters);

        if (count($notifications) >= SELF::COUNT_NOT_READED_NOTIFICATION ) {
            event(new ActualizationGroupNotification($notifications));
        }

    }
}
