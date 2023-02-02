<?php
declare(strict_types=1);
namespace Tests\Feature\Repository;

use App\Models\Group;
use App\Models\User;
use App\Repository\Eloquent\GroupRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupTest extends TestCase
{
    private $repository, $groupData, $groupUpdateData;
    protected function setUp(): void
    {
        parent::setUp();
        $group = Group::factory()->create([
            'id' => 1
        ]);

        $this->repository = new GroupRepository($group);

        $this->groupData = [
            'name' => 'TestTest',
            'available' => 1,
        ];

        $this->groupUpdateData = [
            'name' => 'Tes',
            'available' => "gdsg",
        ];
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

    public function testFindIssetGroup() {
        $result = $this->repository->findOrFail(1);

        $this->assertFalse(empty($result));
    }

    public function testFindDontIssetGroup() {
        try{
            $this->repository->findOrFail(2);
            $this->assertTrue(false);
        } catch (ModelNotFoundException) {
            $this->assertTrue(true);
        }

    }
    public function testGroupFindWithUser() {
        User::factory()->count(3)->create([
            'group_id' => 1
        ]);

        User::factory()->count(3)->create([
            'group_id' => 2
        ]);

        $result = $this->repository->findOrFail(1);

        $correctCountRelationUser = count($result->relationUser) === 3;

        $this->assertTrue($correctCountRelationUser);
    }

    public function testGroupFindWithDontUser() {
        User::factory()->count(3)->create([
            'group_id' => 3
        ]);

        User::factory()->count(3)->create([
            'group_id' => 2
        ]);

        $result = $this->repository->findOrFail(1);

        $correctCountRelationUser = count($result->relationUser) === 0;

        $this->assertTrue($correctCountRelationUser);
    }

    public function testGroupCreate() {

        $this->repository->create($this->groupData);

        $this->assertDatabaseHas('groups', $this->groupData);
    }

    public function testGroupUpdate() {

        $this->repository->update($this->groupUpdateData, 1);

        $this->assertDatabaseHas('groups', $this->groupUpdateData)
            ->assertDatabaseMissing('groups', $this->groupData);
    }

    public function testGroupDestroy() {

        $this->repository->destroy(1);

        $this->assertDatabaseMissing('groups', [
            'id' => 1
        ]);
    }
}
