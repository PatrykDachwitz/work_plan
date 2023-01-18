<?php
declare(strict_types=1);
namespace App\Repository;

interface CalendarCommand
{
    public function insert(array $days);
}