<?php
declare(strict_types=1);
namespace App\Repository;

use App\Models\User;

interface UserRepository
{
    public function update(array $data, int $id);
    public function findOrFail(array|int $id);
    public function create(array $data);
    public function get(array|string $column = '*');
    public function changeRole(int $id, int $role_id);
    public function changeGroup(int $id, int $group_id);
}