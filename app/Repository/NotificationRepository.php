<?php

namespace App\Repository;

interface NotificationRepository
{
    public function findOrFail(int $id);
    public function get(array $filters = [], array|string $column = '*');
    public function update(array $data,int $id);
    public function create(array $data);
    public function destroy(int $id);
}