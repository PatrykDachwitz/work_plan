<?php

namespace App\Repository\Eloquent;

use App\Models\Status;
use Carbon\Carbon;

class StatusRepository implements \App\Repository\StatusRepository
{
    private $status;

    public function __construct(Status $status) {
        $this->status = $status;
    }

    public function findOrFail(int $id)
    {
        return $this->status
            ->with('relationEvents')
            ->with('relationDay')
            ->findOrFail($id);
    }

    public function get(array $filters = [], int $limit = 10, array|string $column = '*')
    {
        $statuses = $this->status->newQuery();
        foreach ($filters ?? [] as $columnName => $filter) {
            if (is_array($filter)) {
                foreach ($filter ?? [] as $valueFilter) {
                    if (is_array($valueFilter)) {
                        if (isset($valueFilter['type'])) {
                            $statuses->where($columnName, $valueFilter['type'], $valueFilter['value']);
                        } else {
                            $statuses->where($columnName, $valueFilter['value']);
                        }
                    } else {
                        $statuses->where($columnName, $valueFilter);
                    }
                }
            } else {
                $statuses->where($columnName, $filter);
            }
        }

        $statuses->limit($limit);
        return $statuses
            ->with('relationEvents')
            ->with('relationDay')
            ->orderBy('date')
            ->get($column);
    }

    public function update(array $data, int $id)
    {
        $status = $this->status->findOrFail($id);

        $status->status = $data['status'] ?? $status->status;
        $status->accepted = $data['accepted'] ?? $status->accepted;
        $status->accepted_user_id = $data['accepted_user_id'] ?? $status->accepted_user_id;
        $status->user_id = $data['user_id'] ?? $status->user_id;
        $status->day_id = $data['day_id'] ?? $status->day_id;
        $status->hour_start = $data['hour_start'] ?? $status->hour_start;
        $status->hour_end = $data['hour_end'] ?? $status->hour_end;
        $status->complety_time = $data['complety_time'] ?? $status->complety_time;
        $status->date = $data['date'] ?? $status->date;
        $status->updated_at = date('Y-m-d H:i:s');
        $status->save();

        return $status;
    }

    public function create(array $data)
    {
        if (!isset($data[0]['status']))
        {
            $status = $this->status::create($data);

        } else {
            $status = $this->status::insert($data);
        }
        return $status;
    }

    public function destroy(int $id)
    {
        return $this->status->findOrFail($id)->delete();
    }

    public function findByDataAndUser(int $idUser, string $date)
    {
        return $this->status->where('user_id', $idUser)->where('date', $date)->first();
    }
}