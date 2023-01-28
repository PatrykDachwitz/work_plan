<?php
declare(strict_types=1);
namespace Tests\Feature\Repository;

use App\Models\Group;
use App\Models\User;
use App\Repository\Eloquent\GroupRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupTest extends TestCase
{
    private $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $group = Group::factory()->create([
            'id' => 1
        ]);
        $this->repository = new GroupRepository($group);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGroupGet()
    {
        Group::factory()->count(3)->create();

        $result = $this->repository->get();

        $countResult = count($result) === 4;
        $this->assertTrue($countResult);
    }

    public function testGroupGetWithUser() {
        User::factory()->count(3)->create([
            'group_id' => 1
        ]);

        User::factory()->count(3)->create([
            'group_id' => 2
        ]);

        $result = $this->repository->get();

        $correctCountRelationUser = count($result[0]->relationUser) === 3;

        $this->assertTrue($correctCountRelationUser);
    }
}
