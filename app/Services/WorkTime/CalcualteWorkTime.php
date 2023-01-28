<?php
declare(strict_types=1);
namespace App\Services\WorkTime;

use App\Models\Day;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CalcualteWorkTime
{
    private $timeWorkHour, $monthAndYear, $startTime, $endTime;
    private const  WORK_DAY_MINUTS = 8 * 60;

    public function __construct($startTime, $endTime, $monthAndYear) {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->timeWorkHour = $this->getCountWorkDay($startTime, $endTime);
        $this->monthAndYear = $monthAndYear;
    }

    public function calculateUser(User $user) {
        $idUser = $user->id;
        $status = new Status();

        return [
            'date' => $this->monthAndYear,
            'user_id' => $idUser,
            'holidays_time' => $status->scopeGetTime($idUser, 'holidayLeave', $this->startTime, $this->endTime),
            'delegation_time' => $status->scopeGetTime($idUser, 'delegation', $this->startTime, $this->endTime),
            'sick_leave' => $status->scopeGetTime($idUser, 'sickLeave', $this->startTime, $this->endTime),
            'work_time' => $status->scopeGetTime($idUser, 'workDay', $this->startTime, $this->endTime),
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

        return count($countWorkDays) * SELF::WORK_DAY_MINUTS;
    }
}