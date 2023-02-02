<?php
declare(strict_types=1);
namespace App\Repository;

interface GroupRepository
{
    public function get(array|string $column = "*");
    public function findOrFail(int $id);
    public function update(array $data, int $id);
    public function create(array $data);
    public function destroy(int $id);
}