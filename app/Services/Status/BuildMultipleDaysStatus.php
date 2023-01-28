<?php
declare(strict_types=1);
namespace App\Services\Status;

class BuildMultipleDaysStatus
{
    protected $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function dateToTimestamp(string $date)
    {
        return strtotime($date);
    }

    public function timestampToDate(int $time)
    {
        return date("d-m-Y", $time);
    }

    public function getCompleteTime(string $startTime = null, string $endTime = null)
    {

        if (!is_null($startTime) & !is_null($endTime))
        {
            return (strtotime($endTime) - strtotime($startTime)) / 60;
        } else {
            return 0;
        }
    }
    public function getConvert()
    {
        $startTime = $this->dateToTimestamp($this->data['date_start']);
        $startEnd = $this->dateToTimestamp($this->data['date_end']);
        $completyStatus = [];
        $complety_time = $this->getCompleteTime($this->data['hour_start'], $this->data['hour_end']);
        /*
         * Build structore Status
         * 24 hour = 86400s
         */
        if($startEnd === $startTime) {
            $actualyDate = $this->timestampToDate($startTime);

            $completyStatus = [
                'user_id' => $this->data['user_id'],
                'day_id' => 1,
                'complety_time' => $complety_time,
                'hour_start' => $this->data['hour_start'] ?? null,
                'hour_end' => $this->data['hour_end'] ?? null,
                'date' => $actualyDate,
                'status' => $this->data['status'] ?? "workDay",
            ];
            $startTime += 86400;
        }

        while ($startEnd >= $startTime) {
            $actualyDate = $this->timestampToDate($startTime);

            $completyStatus[] = [
                'user_id' => $this->data['user_id'],
                'day_id' => 1,
                'complety_time' => $complety_time,
                'hour_start' => $this->data['hour_start'] ?? null,
                'hour_end' => $this->data['hour_end'] ?? null,
                'date' => $actualyDate,
                'status' => $this->data['status'] ?? "workDay",
            ];
            $startTime += 86400;
        }
        return $completyStatus;
    }

}