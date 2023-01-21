<?php
declare(strict_types=1);
namespace Tests\Feature;

use App\Models\Status;
use App\Repository\Eloquent\StatusRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatusTest extends TestCase
{

    use DatabaseMigrations, RefreshDatabase;

    private $repository, $testDate = [
        'hour_start' => "7:00",
        'hour_end' => "15:00",
        'date' => "15-02-2023",
        'user_id' =>1,
        'day_id' => 1,
        'status' => 'workDay',
    ], $filters = [
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


    public function factory(array $values = [])
    {
        $status = Status::factory()->create($values);
        $this->repository = new StatusRepository($status);
    }

    public function test_statuses_find()
    {
        $this->factory([
            'id' => 1
        ]);

        $status = $this->repository->findOrFail(1);

        $this->assertFalse(empty($status));
    }

    public function test_statuses_not_found_model()
    {
        $this->factory([
            'id' => 1
        ]);

        try {
            $status = $this->repository->findOrFail(2);
        } catch (ModelNotFoundException) {
            $this->assertTrue(true);
        }
        $this->assertTrue(empty($status));
    }

    public function test_statuses_update()
    {
        $this->factory([
            'id' => 1
        ]);

        $status = $this->repository->update($this->testDate, 1);

        $this->assertFalse(empty($status));
    }

    public function test_statuses_create()
    {
        $this->factory([
            'id' => 1
        ]);

        $status = $this->repository->create($this->testDate);

        $this->assertFalse(empty($status));
    }

    public function test_statuses_destroy()
    {
        $this->factory([
            'id' => 1
        ]);

        $this->repository->destroy(1);

        try {
            $status = $this->repository->findOrFail(1);
        } catch (ModelNotFoundException) {
            $this->assertTrue(true);
        }

        $this->assertTrue(empty($status));
    }

    public function test_statuses_get()
    {
        $this->factory();

        $statues = $this->repository->get();

        $countOneModel = count($statues) === 1;

        $this->assertTrue($countOneModel);
    }

    public function test_statuses_get_filters()
    {
        $this->factory();

        $this->repository->create($this->testDate);

        $statues = $this->repository->get($this->filters);

        $countOneModel = count($statues) === 1;

        $this->assertTrue($countOneModel);
    }
}
