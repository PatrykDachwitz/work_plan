<?php

namespace App\Repository\Eloquent;

use App\Models\Event;

class EventRepository implements \App\Repository\EventRepository
{
    private $event;

    public function __construct(Event $event) {
        $this->event = $event;
    }

    public function findOrFail(int $id)
    {
        return $this->event->findOrFail($id);
    }

    public function get(array $filters = [], array|string $column = '*')
    {
        $event = $this->event->newQuery();

        foreach ($filters ?? [] as $columnName => $filter) {
            $event->where($columnName, $filter);
        }

        return $event->get($column);
    }

    public function update(array $data, int $id)
    {
        $event = $this->event->findOrFail($id);

        $event->date = $data['date'] ?? $event->date;
        $event->description = $data['description'] ?? $event->description;
        $event->save();

        return $event;
    }

    public function create(array $data)
    {
        $event = new $this->event();
        $event->date = $data['date'];
        $event->user_id = $data['user_id'];
        $event->status_id = $data['status_id'];
        $event->description = $data['description'] ?? null;

        $event->save();
        return $event;
    }

    public function destroy(int $id)
    {
        $this->event->findOrFail($id)->delete();
    }
}