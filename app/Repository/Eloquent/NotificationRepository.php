<?php

namespace App\Repository\Eloquent;

use App\Models\Notification;

class NotificationRepository implements \App\Repository\NotificationRepository
{

    private $notification;

    public function __construct(Notification $notification) {
        $this->notification = $notification;
    }

    public function findOrFail(int $id)
    {
        return $this->notification->findOrFail($id);
    }

    public function get(array $filters = [], array|string $column = '*')
    {
        $notification = $this->notification->newQuery();

        foreach ($filters ?? [] as $columnName => $value) {
            $notification->where($columnName, $value);
        }

        return $notification->get($column);
    }

    public function update(array $data, int $id)
    {
        $notification = $this->notification->findOrFail($id);

        $notification->description = $data['description'] ?? $notification->description;
        $notification->url_action = $data['url_action'] ?? $notification->url_action;
        $notification->readed = $data['readed'] ?? $notification->readed;

        $notification->save();
        return $notification;
    }

    public function create(array $data)
    {
        $notification = new $this->notification();

        $notification->description = $data['description'];
        $notification->url_action = $data['url_action'];
        $notification->user_id = $data['user_id'];
        $notification->author_id = $data['author_id'];
        if(isset($data['readed'])) $notification->readed = $data['readed'];

        $notification->save();
        return $notification;
    }

    public function destroy(int $id)
    {
        return $this->notification->findOrFail($id)->delete();
    }
}