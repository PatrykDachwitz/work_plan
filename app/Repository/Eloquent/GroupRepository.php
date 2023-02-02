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

    public function findOrFail(int $id)
    {
        return $this->group
            ->with('relationUser')
            ->findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $group = $this->group->findOrFail($id);

        $group->name = $data['name'] ?? $group->name;
        $group->available = $data['available'] ?? $group->available;

        $group->save();

        return $group;
    }

    public function create(array $data)
    {
        return $this->group->create($data);
    }

    public function destroy(int $id)
    {
        $this->group->delete($id);
    }
}