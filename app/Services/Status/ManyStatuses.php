<?php
declare(strict_types=1);
namespace App\Services\Status;

use App\Http\Resources\Days;
use App\Repository\DayRepository;
use App\Repository\StatusRepository;
use Carbon\Carbon;

class ManyStatuses
{
    private $dayRepository, $statusRepository;

    public function __construct(DayRepository $dayRepository, StatusRepository $statusRepository) {
        $this->dayRepository = $dayRepository;
        $this->statusRepository = $statusRepository;
    }

    private function getIdDay(string $startDate, string $endDate) {
        $filters = [
            'date' =>
                [
                    1 => [
                    'value' => $startDate,
                    'type' => ">="
                ],
                    2 => [
                        'value' => $endDate,
                        'type' => "<="
                ]]
            ];

        $days = $this->dayRepository
            ->get($filters);

        return $days;
    }

    public function insert(array $data) {
        $userId = $data['user_id'];
        $status = $data['status'];
        $endDate = $data['day_end'];
        $startDate = $data['day_start'];

        $days = $this->getIdDay($startDate, $endDate);
        $data = [];
        foreach ($days ?? [] as $day) {

            // 0 - day, 1 - month, 2 - year
            $date = explode("-", $day->date);
            $startDate = $date[2] . "-" . $date[1] . "-" . $date[0] . " 07:00:00";
            $endDate = $date[2] . "-" . $date[1] . "-" . $date[0] . " 15:00:00";

            $data[] = [
                'user_id' => $userId,
                'day_id' => $day->id,
                'time_start' => $startDate,
                'time_end' => $endDate,
                'status' => $status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        $this->statusRepository->create($data);
    }
}