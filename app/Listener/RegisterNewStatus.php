<?php
declare(strict_types=1);
namespace App\Listener;

use App\Event\RegisterStatus;
use App\Repository\DayRepository;
use App\Repository\StatusRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterNewStatus
{
    protected $statusRepository, $dayRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(StatusRepository $statusRepository, DayRepository $dayRepository)
    {
        $this->statusRepository = $statusRepository;
        $this->dayRepository = $dayRepository;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Event\RegisterStatus  $event
     * @return void
     */
    public function handle(RegisterStatus $event)
    {
        $day = $this->dayRepository->findByDate($event->data['date']);
        $data = [
            'day_id' => $day->id ?? 0,
            'date' => $day->date ?? $event->data['date'],
            'user_id' => $event->data['user_id'],
            'status' => 'workDay',
        ];

        if (isset($event->data['exitWork'])) {
            if ($event->data['exitWork']) $data['hour_end'] = $event->data['hour'];
        }
        if (isset($event->data['startWork'])) {
            if ($event->data['startWork']) $data['hour_start'] = $event->data['hour'];
        }

         return ($this->statusRepository->create($data))->id;
    }
}
