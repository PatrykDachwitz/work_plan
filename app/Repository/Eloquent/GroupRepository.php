<?php
declare(strict_types=1);
namespace App\Repository\Eloquent;

use App\Models\Group;

class GroupRepository implements \App\Repository\GroupRepository
{
    private $group;

    public function __construct(Group $group) {
        $this->group = $group;
    }

    public function get(array|string $column = "*")
    {
        return $this->group
            ->with('relationUser')
            ->get($column);
    }
}