<?php
declare(strict_types=1);
namespace App\Repository;

interface StatusRepository
{
    public function findOrFail(int $id);
    public function get(array $filters = [], int $limit = 10, array|string $column = '*');
    public function update(array $data,int $id);
    public function create(array $data);
    public function destroy(int $id);
}