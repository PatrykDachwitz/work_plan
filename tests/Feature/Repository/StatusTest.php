<?php
declare(strict_types=1);
namespace Repository;

use App\Models\Event;
use App\Models\Status;
use App\Models\User;
use App\Repository\Eloquent\StatusRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{

    use DatabaseMigrations, RefreshDatabase;

    private $repository, $statusData, $filters;

    protected function setUp(): void
    {
        parent::setUp();
        $status = Status::factory()->create([
            'id' => 1,
        ]);
        $this->repository = new StatusRepository($status);

        $this->filters = [
            'user_id' => 1,
            'day_id' => 1,
            'status' => 'workDay',
            'date' => [
                [
                    'value' => '15-02-2023',
                    'type' => ">="
                ]
            ],
        ];

        $this->statusData = [
            'hour_start' => "07:00",
            'hour_end' => "15:00",
            'date' => "15-02-2023",
            'user_id' =>1,
            'day_id' => 1,
            'status' => 'workDay',
        ];
    }

    public function testFindByDataAndUser()
    {
        $this->repository->create($this->statusData);

        $response = $this->repository->findByDataAndUser(1, "15-02-2023");
        $this->assertArrayHasKey('date', $response);
        $this->assertArrayHasKey('user_id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('complety_time', $response);
    }
    public function testFindByDataAndUserNotIsset()
    {
        $this->repository->create($this->statusData);

        $response = $this->repository->findByDataAndUser(15, "15-02-2023");

        $this->assertTrue(empty($response));
    }
    public function testStatusFind()
    {
        $status = $this->repository->findOrFail(1);

        $this->assertFalse(empty($status));
    }

    public function testStatusNotFoundModel()
    {
        try {
            $status = $this->repository->findOrFail(2);
        } catch (ModelNotFoundException) {
            $this->assertTrue(true);
        }
        $this->assertTrue(empty($status));
    }

    public function testStatusUpdate()
    {
        $this->repository->update($this->statusData, 1);

        $this->assertDatabaseHas('statuses', $this->statusData);
    }

    public function testStatusAccepted()
    {
        $data = [
            'id' => 1,
            'accepted' => true,
            'accepted_user_id' => 1
        ];
        $this->repository->update($data, 1);

        $this->assertDatabaseHas('statuses', $data);
    }

    public function testStatusCreate()
    {
        $status = $this->repository->create($this->statusData);

        $this->assertDatabaseHas('statuses', $this->statusData);
    }

    public function testStatusDestroy()
    {
        $this->repository->destroy(1);

        $this->assertDatabaseMissing('statuses', [
            'id' => 1
        ]);
    }

    public function testStatusGet()
    {

        $statues = $this->repository->get();

        $countOneModel = count($statues) === 1;
        $this->assertTrue($countOneModel);
    }


    public function testStatusGetWithEvent()
    {
        Event::factory()->create([
            'user_id' => 1,
            'status_id' => 1
        ]);

        $statues = $this->repository->get();

        $issetRelationEvent = isset($statues[0]->relationEvents[0]);

        $this->assertTrue($issetRelationEvent);
    }
    public function testStatusGetWithDontIssetEvent()
    {
        $statues = $this->repository->get();

        $issetRelationEvent = isset($statues[0]->relationEvents[0]);

        $this->assertFalse($issetRelationEvent);
    }

}
