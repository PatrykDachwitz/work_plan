<?php
declare(strict_types=1);
namespace App\Services\WorkTime;

use App\Models\Day;
use App\Models\User;

class CalcualteWorkTime
{
    private $timeWorkHour, $monthAndYear;
    private const  WORK_DAY_HOUR = 8;

    public function __construct($startTime, $endTime, $monthAndYear) {
        $this->timeWorkHour = $this->getCountWorkDay($startTime, $endTime);
        $this->monthAndYear = $monthAndYear;
    }

    public function calculateUser(User $user) {
        return [
            'date' => $this->monthAndYear,
            'user_id' => $user->id,
            'holidays_time' => 0,
            'delegation_time' => 0,
            'sick_leave' => 0,
            'work_time' => 0,
            'completely_available_time' => $this->timeWorkHour,
        ];
    }


    private function getCountWorkDay($startTime, $endTime) {

        $days = new Day();
        $countDay = $days->newQuery();
        $countDay->where('date', '>=', $startTime);
        $countDay->where('date', '<=', $endTime);
        $countDay->where('free_day', 0);

        $countWorkDays = $countDay->get();

        return count($countWorkDays) * SELF::WORK_DAY_HOUR;
    }
}