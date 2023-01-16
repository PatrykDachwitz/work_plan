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

        foreach ($filters as $columnName => $filter) {
            if(is_array($filter)) {
                $statuses->where($columnName, $filter['type'], $filter['value']);
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

        $status->time_start = $data['time_start'] ?? $status->time_start;
        $status->time_end = $data['time_end'] ?? $status->time_end;
        $status->status = $data['status'] ?? $status->status;
        $status->accepted = $data['accepted'] ?? $status->accepted;
        $status->accepted_user_id = $data['accepted_user_id'] ?? $status->accepted_user_id;

        $status->save();

        return $status;
    }

    public function create(array $data)
    {
        $status = $this->status::insert($data);
        /*
        $status = new $this->status();

        $status->user_id = $data['user_id'];
        $status->day_id = $data['day_id'];
        $status->status = $data['status'];

        if(!empty($data['time_start'])) $status->time_start = $data['time_start'];
        if(!empty($data['time_end'])) $status->time_start = $data['time_end'];
        $status->save();
*/
        return $status;
    }

    public function destroy(int $id)
    {
        $this->status->findOrFail($id)->delete();
    }
}