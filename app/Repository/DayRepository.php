<?php

namespace App\Repository;

interface DayRepository
{
    public function findOrFail(int $id);
    public function get(array $filters = [], int $limit = 30, string|array $column = "*");
    public function update(array $data,int $id);
    public function create(array $data);
    public function destroy(int $id);
    public function findByDate(string $date);
    public function getWithUserStatus(int $id, array $filters = [], int $limit = 30);
}