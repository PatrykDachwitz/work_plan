<?php
declare(strict_types=1);
namespace App\Repository;

interface UserRepository
{
    public function update(array $data, int $id);
    public function findOrFail(int $id);
    public function create(array $data);
}