<?php
declare(strict_types=1);
namespace App\Repository\Eloquent;
use App\Models\Day;
use App\Repository\DayRepository as DayInterface;
use App\Repository\CalendarCommand;

class DayRepository implements DayInterface, CalendarCommand
{
    private $day, $id;

    public function __construct(Day $day) {
        $this->day = $day;
    }

    public function findOrFail(int $id)
    {
        return $this->day->findOrFail($id);
    }

    public function get(array $filters = [], int $limit = 30, string|array $column = "*")
    {
        $days = $this->day->newQuery();

        foreach ($filters ?? [] as $columnName => $filter) {
            foreach ($filter ?? [] as $valueFilter) {
                if (is_array($valueFilter)) {
                    if (isset($valueFilter['type'])) {
                        $days->where($columnName, $valueFilter['type'], $valueFilter['value']);
                    } else {
                        $days->where($columnName, $valueFilter['value']);
                    }
                } else {
                    $days->where($columnName, $valueFilter);
                }
            }
        }
        $days->limit($limit);
        $days->orderBy('date');
        return $days->get($column);
    }

    public function update(array $data, int $id)
    {
        $day = $this->day->findOrFail($id);

        if (isset($data['date'])) $dayAndMonth = $this->getDayAndMonth($data['date']);

        $day->date = $data['date'] ?? $day->date;
        $day->day = $dayAndMonth['day'] ?? $day->day;
        $day->month = $dayAndMonth['month'] ?? $day->month;
        $day->day_name = $data['day_name'] ?? $day->day_name;
        $day->free_day = $data['free_day'] ?? $day->free_day;

        $day->save();
        return $day;
    }

    private function getDayAndMonth(string $date) {
        $time = strtotime($date);

        return [
            'day' => date('d', $time),
            'month' => date('M', $time),
        ];
    }
    public function create(array $data)
    {
        $day = new $this->day();

        $dayAndMonth = $this->getDayAndMonth($data['date']);

        $day->date = $data['date'];
        $day->day = $dayAndMonth['day'];
        $day->month = $dayAndMonth['month'];
        $day->day_name = $data['day_name'];
        if(isset($data['free_day'])) $day->free_day = $data['free_day'];

        $day->save();
        return $day;
    }

    public function destroy(int $id)
    {
        $this->day->findOrFail($id)->delete();
    }

    public function insert(array $days)
    {
        $this->day->insert($days);
    }

    public function findByDate(string $date)
    {
        return $this->day
            ->where('date', $date)
            ->first();
    }

    public function getWithUserStatus(int $id, array $filters = [], int $limit = 30)
    {
        $this->id = $id;

        $query = $this->day->newQuery();
        $query->with([
            'relationStatus' => function ($query) {
                $query->where('user_id', $this->id);
            }
        ]);

        foreach ($filters ?? [] as $columnName => $filter) {
            foreach ($filter ?? [] as $valueFilter) {
                if (is_array($valueFilter)) {
                    if (isset($valueFilter['type'])) {
                        $query->where($columnName, $valueFilter['type'], $valueFilter['value']);
                    } else {
                        $query->where($columnName, $valueFilter['value']);
                    }
                } else {
                    $query->where($columnName, $valueFilter);
                }
            }
        }

        $query->limit($limit);
        $query->orderBy('date');
        return $query->get();
    }
}