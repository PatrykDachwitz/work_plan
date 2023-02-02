<?php
declare(strict_types=1);
namespace Repository;

use App\Models\Day;
use App\Models\Status;
use App\Models\User;
use App\Repository\Eloquent\DayRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DayTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    private $testData, $repository, $filters;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
        $days = Day::factory()->create([
            'date' => "15-02-2023",
            'id' => 1
        ]);
        $this->repository = new DayRepository($days);
        $this->filters = [
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
        $this->dayData = [
            'date' => "12-12-2023",
            'day_name' => 'Piątek',
            'free_day' => 0,
            'day' => 12,
            'month' => 'Dec',
        ];
    }

    public function testCreateDay()
    {
        $this->repository->create($this->dayData);

        $this->assertDatabaseHas('days', $this->dayData);
    }

    public function testUpdateDay()
    {
        $this->repository->update($this->dayData, 1);

        $this->assertDatabaseHas('days', $this->dayData);
    }

    public function testFindDay()
    {
        $day = $this->repository->findOrFail(1);

        $this->assertFalse(empty($day));
    }

    public function testDestroyDay()
    {
        $this->repository->destroy(1);

        $this->assertDatabaseMissing('days', [
            'id' => 1
        ]);
    }

    public function testGetDay()
    {
        $day = $this->repository->get();

        $countOneModel = count($day) === 1;

        $this->assertTrue($countOneModel);
    }

    public function testGetDayLimits()
    {
        Day::factory()->count(30)
            ->create();
        $day = $this->repository->get([], 30);

        $countOneModel = count($day) === 30;

        $this->assertTrue($countOneModel);
    }

    public function testGetDayFilterByDate()
    {
        Day::factory()->create([
            'date' => '29-01-2023'
        ]);
        $filter = [
            'date' => [
                [
                    'value' => "29-01-2023",
                    'type' => ">="
                ]
            ]
        ];

        $day = $this->repository->get($filter);
        $this->assertTrue($day[0]->date === '29-01-2023');
    }

    public function testGetDayLimitsWithStatus()
    {
        Day::factory()->count(30)
            ->create();
        $day = $this->repository->getWithUserStatus(1, [], 30);

        $countOneModel = count($day) === 30;

        $this->assertTrue($countOneModel);
    }

    public function testGetDayFilterByDateWithStatus()
    {
        Day::factory()->create([
            'date' => '29-01-2023'
        ]);
        $filter = [
            'date' => [
                [
                    'value' => "29-01-2023",
                    'type' => ">="
                ]
            ]
        ];

        $day = $this->repository->getWithUserStatus(1, $filter);
        $this->assertTrue($day[0]->date === '29-01-2023');
    }

    public function testGetDaysWithStatus()
    {
        User::factory()->create([
            'id' => 2
        ]);

        for ($i = 1 ; $i < 15; $i++) {
            Status::factory()->create([
                'user_id' => $i,
                'date' => "15-02-2023"
            ]);
        }


        $day = $this->repository->getWithUserStatus(2);

        $correctCountStatus = count($day[0]->relationStatus) === 1;

        $this->assertTrue($correctCountStatus);
    }

    public function testGetByFiltersDay()
    {
        $this->repository->create($this->dayData);

        $day = $this->repository->get($this->filters);

        $countOneModel = count($day) === 1;

        $this->assertTrue($countOneModel);
    }

    public function testFindByDate()
    {
        $this->repository->create($this->dayData);

        $day = $this->repository->findByDate('12-12-2023');

        $this->assertFalse(empty($day));
    }
}
