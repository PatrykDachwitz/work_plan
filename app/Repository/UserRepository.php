<?php
declare(strict_types=1);
namespace App\Repository;

use App\Models\User;

interface UserRepository
{
    public function update(array $data, User $updateUser);
    public function findOrFail(array|int $id);
    public function create(array $data);
    public function get(array|string $column = '*');
}