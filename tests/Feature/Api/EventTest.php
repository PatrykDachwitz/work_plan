<?php
declare(strict_types=1);
namespace Tests\Feature\Api;

use App\Models\Status;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateEventStatusIsset()
    {
        $validDate = [
            'date' => "12-12-2022",
            'hour' => "07:00",
            'user_id' => 1,
            'status_id' => 1,
            'description' => "test",
        ];
        $response = $this->post(route('event.store'), $validDate);

        $this->assertDatabaseHas('events', $validDate);
        $response->assertStatus(200);
    }

    public function testCreateEventWithCreateStatusNoneTime()
    {
        $validDate = [
            'date' => "12-12-2022",
            'hour' => "07:00",
            'user_id' => 1,
            'description' => "test",
        ];

        $response = $this->post(route('event.store'), $validDate);

        $this->assertDatabaseHas('events', $validDate)
            ->assertDatabaseHas('statuses', [
                'hour_start' => null,
                'hour_end' => null,
                'date' => "12-12-2022",
                'user_id' => 1
            ]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            'id',
            'description',
            'status_id',
        ]);
    }

    public function testCreateEventWithCreateStatusNoneTimeNoneValueStatusId()
    {
        $validDate = [
            'date' => "12-12-2022",
            'hour' => "07:00",
            'user_id' => 1,
            'description' => "test",
            'status_id' => null
        ];
        unset($validDate['status_id']);
        $response = $this->post(route('event.store'), $validDate);

        $this->assertDatabaseHas('events', $validDate)
            ->assertDatabaseHas('statuses', [
                'hour_start' => null,
                'hour_end' => null,
                'date' => "12-12-2022",
                'user_id' => 1
            ]);
        $response->assertStatus(200);
    }

    public function testCreateEventWithCreateStatusEndTime()
    {
        $validDate = [
            'date' => "12-12-2022",
            'hour' => "07:00",
            'user_id' => 1,
            'description' => "test",
            'exitWork' => true
        ];

        $response = $this->post(route('event.store'), $validDate);
        unset($validDate['exitWork']);
        $this->assertDatabaseHas('events', $validDate)
            ->assertDatabaseHas('statuses', [
                'hour_start' => null,
                'hour_end' => "07:00",
                'complety_time' => 0,
                'date' => "12-12-2022",
                'user_id' => 1
            ]);
        $response->assertStatus(200);
    }

    public function testCreateEventWithCreateStatusStartTime()
    {
        $validDate = [
            'date' => "12-12-2022",
            'hour' => "07:00",
            'user_id' => 1,
            'description' => "test",
            'startWork' => true
        ];

        $response = $this->post(route('event.store'), $validDate);
        unset($validDate['startWork']);
        $this->assertDatabaseHas('events', $validDate)
            ->assertDatabaseHas('statuses', [
                'hour_end' => null,
                'hour_start' => "07:00",
                'complety_time' => 0,
                'date' => "12-12-2022",
                'user_id' => 1
            ]);
        $response->assertStatus(200);
    }

    public function testCreateEventWithCreateStatusFullTimFirstStartWork()
    {
        $validDate = [
            'date' => "12-12-2022",
            'hour' => "07:00",
            'user_id' => 1,
            'description' => "test",
            'startWork' => true
        ];

        $response = $this->post(route('event.store'), $validDate);
        $validDate['hour'] = "15:00";
        unset($validDate['startWork']);
        $validDate['exitWork'] = true;
        $validDate['status_id'] = 1;
        $responseTwo = $this->post(route('event.store'), $validDate);
        unset($validDate['exitWork']);
        $this->assertDatabaseHas('events', $validDate)
            ->assertDatabaseHas('statuses', [
                'hour_end' => "15:00",
                'hour_start' => "07:00",
                'complety_time' => "480",
                'date' => "12-12-2022",
                'user_id' => 1
            ]);
        $response->assertStatus(200);
        $responseTwo->assertStatus(200);
    }

    public function testCreateEventWithCreateStatusFullTimFirstExitWork()
    {
        $validDate = [
            'date' => "12-12-2022",
            'hour' => "15:00",
            'user_id' => 1,
            'description' => "test",
            'exitWork' => true
        ];

        $response = $this->post(route('event.store'), $validDate);
        $validDate['hour'] = "07:00";
        unset($validDate['exitWork']);
        $validDate['startWork'] = true;
        $validDate['status_id'] = 1;
        $responseTwo = $this->post(route('event.store'), $validDate);
        unset($validDate['startWork']);
        $this->assertDatabaseHas('events', $validDate)
            ->assertDatabaseHas('statuses', [
                'hour_end' => "15:00",
                'hour_start' => "07:00",
                'complety_time' => "480",
                'date' => "12-12-2022",
                'user_id' => 1
            ]);
        $response->assertStatus(200);
        $responseTwo->assertStatus(200);
    }

    public function testCreateEventWithCreateStatusSameoneTime()
    {
        $validDate = [
            'date' => "12-12-2022",
            'hour' => "07:00",
            'user_id' => 1,
            'description' => "test",
            'startWork' => true,
            'exitWork' => true
        ];

        $response = $this->post(route('event.store'), $validDate);

        unset($validDate['startWork']);
        unset($validDate['exitWork']);
        $this->assertDatabaseHas('events', $validDate)
            ->assertDatabaseHas('statuses', [
                'hour_end' => "07:00",
                'hour_start' => "07:00",
                'complety_time' => "0",
                'date' => "12-12-2022",
                'user_id' => 1
            ]);
        $response->assertStatus(200);
    }

    public function testErrorValidateStoreValueEvent()
    {
        $response = $this->post(route('event.store'), [
            'date' => "2022-12-2",
            'hour' => "23:0",
            'user_id' => "wer",
            'status_id' => "we",
            'description' => "łętest./?>",
            'startWork' => "test",
            'exitWork' => "test",
        ]);

        $response->assertSessionHasErrors([
            'date',
            'hour',
            'user_id',
            'status_id',
            'description',
            'startWork',
            'exitWork',
        ]);
    }

    public function testShowEvent()
    {
        Event::factory()->create([
            'id' => 1
        ]);

        $response = $this->get(route("event.show", [
            'event' => 1
        ]));

        $response->assertJsonStructure([
            'description',
            'user_id',
            'status_id',
            'id',
        ]);
    }
    public function testDeleteEvent()
    {
        Event::factory()->create([
            'id' => 1
        ]);

        $response = $this->delete(route("event.destroy", [
            'event' => 1
        ]));

        $this->assertDatabaseMissing('events', [
           'id' => 1
        ]);

        $response->assertStatus(302);
    }
}
