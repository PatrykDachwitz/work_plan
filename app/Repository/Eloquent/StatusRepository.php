<?php

namespace App\Repository\Eloquent;

use App\Models\Status;

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
            ->get($column);
    }

    public function update(array $data, int $id)
    {
        $status = $this->status->findOrFail($id);

        $status->hour_start = $data['hour_start'] ?? $status->hour_start;
        $status->hour_end = $data['hour_end'] ?? $status->hour_end;
        $status->status = $data['status'] ?? $status->status;
        $status->accepted = $data['accepted'] ?? $status->accepted;
        $status->accepted_user_id = $data['accepted_user_id'] ?? $status->accepted_user_id;

        $status->save();

        return $status;
    }

    public function create(array $data)
    {
        $status = $this->status::insert($data);
        return $status;
    }

    public function destroy(int $id)
    {
        return $this->status->findOrFail($id)->delete();
    }
}