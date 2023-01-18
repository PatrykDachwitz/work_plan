<?php
declare(strict_types=1);
namespace App\Repository\Eloquent;
use App\Models\Day;
use App\Repository\DayRepository as DayInterface;
use App\Repository\CalendarCommand;

class DayRepository implements DayInterface, CalendarCommand
{
    private $day;

    public function __construct(Day $day) {
        $this->day = $day;
    }

    public function findOrFail(int $id)
    {
        return $this->day->findOrFail($id);
    }

    public function get(array $filters = [], string|array $column = "*")
    {
        $days = $this->day->newQuery();

        foreach ($filters ?? [] as $columnName => $filter) {
            foreach ($filter ?? [] as $valueFilter) {
                if (is_array($valueFilter)) {
                    $days->where($columnName, $valueFilter['type'], $valueFilter['value']);
                } else {
                    $days->where($columnName, $valueFilter);
                }
            }
        }

        return $days->get($column);
    }

    public function update(array $data, int $id)
    {
        $day = $this->day->findOrFail($id);

        $day->date = $data['date'] ?? $day->date;
        $day->day_name = $data['day_name'] ?? $day->day_name;
        $day->free_day = $data['free_day'] ?? $day->free_day;

        $day->save();
        return $day;
    }

    public function create(array $data)
    {
        $day = new $this->day();

        $day->date = $data['date'];
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
}