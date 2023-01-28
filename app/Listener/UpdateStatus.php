<?php
declare(strict_types=1);
namespace App\Listener;

use App\Event\UpdateIssetStatus;
use App\Repository\StatusRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStatus
{
    private $statusRepository;
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
     * @param  \App\Event\UpdateIssetStatus  $event
     * @return void
     */

    private function calculateCompletyTime(string $endTime, string $startTime)
    {
        if ($endTime > $startTime) {
            $completyTime = (strtotime($endTime) - strtotime($startTime)) / 60;
            if ($completyTime > 0) {
                return $completyTime;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function handle(UpdateIssetStatus $event)
    {
        $status = $this->statusRepository->findOrFail($event->data['status_id']);

        if (isset($event->data['startWork'])) {
            if (!is_null($status->hour_end)) {
                $completyTime = $this->calculateCompletyTime($status->hour_end, $event->data['hour']);
                $nameColumn = 'hour_start';
            }
        } elseif (isset($event->data['exitWork'])) {
            if (!is_null($status->hour_start)) {
                $completyTime = $this->calculateCompletyTime($event->data['hour'], $status->hour_start);
                $nameColumn = 'hour_end';
            }
        }

        $updateData = [
            $nameColumn => $event->data['hour'],
            'complety_time' => $completyTime ?? 0
        ];

        $this->statusRepository->update($updateData, $event->data['status_id']);
    }
}
