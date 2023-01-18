<?php

namespace App\Listener;

use App\Event\NewUser;
use App\Services\WorkTime\BuildHistorieWork;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HistorieWork
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $monthAndYear = date('m-Y');
        $startTime = date('d-m-Y');
        $endTime = "31-" . $monthAndYear;
        $this->buildHistorieWork = new BuildHistorieWork($startTime, $endTime, $monthAndYear);
    }

    /**
     * Handle the event.
     *
     * @param  \App\Event\NewUser  $event
     * @return void
     */
    public function handle(NewUser $event)
    {
        $this->buildHistorieWork->buildHistorieTime([$event->user->id]);
    }

}
