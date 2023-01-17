<?php
declare(strict_types=1);
namespace App\Repository;

interface HistoriesRepository
{
    public function findOrCreate(array $filters);
    public function create(array $data);
    public function findOrFail(int $id = null, array $filters = null);
}