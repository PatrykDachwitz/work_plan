<?php

namespace Tests\Feature;

use App\Models\Day;
use App\Repository\Eloquent\DayRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DayTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    private $testData = [
        'date' => "12-12-2023",
        'day_name' => 'Piątek',
        'free_day' => 0,
    ];
    private $repository;
    private $filters = [
        'free_day' => [
            'value' => 0,
        ],
            'day_name' => [
            'value' => "Piątek"
        ],
        'date' => [
            [
                'value' => "12-12-2023",
            ]
        ]
    ];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    private function factory(array $value = []) {
        $days = Day::factory()->create($value);
        $this->repository = new DayRepository($days);
    }

    public function test_day_create()
    {
        $this->factory();

        $day = $this->repository->create($this->testData);

        $this->assertFalse(empty($day));
    }

    public function test_day_update()
    {
        $this->factory([
            'id' => 1
        ]);

        $day = $this->repository->update($this->testData, 1);

        $this->assertFalse(empty($day));
    }

    public function test_day_find()
    {
        $this->factory([
            'id' => 1
        ]);

        $day = $this->repository->findOrFail(1);

        $this->assertFalse(empty($day));
    }

    public function test_day_destroy()
    {
        $this->factory([
            'id' => 1
        ]);

        $this->repository->destroy(1);

        try {
            $day = $this->repository->findOrFail(1);
        } catch (ModelNotFoundException) {
            $this->assertTrue(true);
        }

        $this->assertTrue(empty($day));
    }

    public function test_day_get()
    {
        $this->factory();

        $day = $this->repository->get();

        $countOneModel = count($day) === 1;

        $this->assertTrue($countOneModel);
    }

    public function test_day_get_filters()
    {
        $this->factory([
            'id' => 1
        ]);
        $this->repository->create($this->testData);

        $day = $this->repository->get($this->filters);

        $countOneModel = count($day) === 1;

        $this->assertTrue($countOneModel);
    }

}
