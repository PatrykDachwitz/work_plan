<?php

namespace App\Listener;

use App\Event\RegisterExitWork;
use App\Repository\StatusRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStatusExit
{

    protected $statusRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Event\RegisterExitWork  $event
     * @return void
     */
    public function handle(RegisterExitWork $event)
    {
        $status = $this->statusRepository->findOrFail($event->data['status_id']);

        if (!is_null($status->hour_start)) {
            $startTime = strtotime($status->hour_start);
            $endTime = strtotime($event->data['hour']);
            $completyTime = ($endTime-$startTime)/60;
        } elseif ('gdf') {

        }
        $updateData = [
            'hour_end' => $event->data['hour'],
            'complety_time' => $completyTime ?? null
        ];

        $this->statusRepository->update($updateData, $event->data['status_id']);
    }
}
