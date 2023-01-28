<?php
declare(strict_types=1);
namespace App\Repository;

interface GroupRepository
{
    public function get(array|string $column = "*");
}