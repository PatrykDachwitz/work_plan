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

    public function get(array|string $column = '*')
    {
        return $this->event->get($column);
    }

    public function update(array $data, int $id)
    {
        $event = $this->event->findOrFail($id);

        $event->date = $data['date'] ?? $event->date;
        $event->description = $data['description'] ?? $event->description;
        $event->hour = $data['hour'] ?? $event->hour;

        $event->save();
        return $event;
    }

    public function create(array $data)
    {
        return $this->event->create($data);
    }

    public function destroy(int $id)
    {
        $this->event->findOrFail($id)->delete();
    }
}