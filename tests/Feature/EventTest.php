<?php
declare(strict_types=1);
namespace Tests\Feature;

use App\Models\Event;
use App\Repository\Eloquent\EventRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;
    private $testData = [
        'date' => '2023-12-12 12:12:12',
        'user_id' => 1,
        'status_id' => 1,
        'description' => "Lorem Ipsum",
    ];
    private $repository;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private function factory(array $values = [])
    {
        $events = Event::factory()->create($values);
        $this->repository = new EventRepository($events);
    }

    public function test_event_find()
    {
       $this->factory([
           'id' => 1
       ]);

       $event = $this->repository->findOrFail(1);

       $this->assertFalse(empty($event));
    }

    public function test_event_create()
    {
       $this->factory();

       $event = $this->repository->create($this->testData);

       $this->assertFalse(empty($event));
    }

    public function test_event_update()
    {
       $this->factory([
           'id' => 1
       ]);

       $event = $this->repository->update($this->testData, 1);

       $this->assertFalse(empty($event));
    }

    public function test_event_destroy()
    {
        $this->factory([
            'id' => 1
        ]);

        $this->repository->destroy(1);

        try {
            $event = $this->repository->findOrFail(1);
        } catch (ModelNotFoundException) {
            $this->assertTrue(true);
        }
        $this->assertTrue(empty($event));
    }

    public function test_event_get()
    {
        $this->factory();

        $event = $this->repository->get();
        $countOne = count($event) === 1;

        $this->assertTrue($countOne);
    }

    public function test_event_get_filtres()
    {
        $this->factory();
        $this->repository->create($this->testData);
        $event = $this->repository->get($this->testData);

        $countOne = count($event) === 1;

        $this->assertTrue($countOne);
    }
}
