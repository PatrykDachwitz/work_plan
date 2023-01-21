<?php
declare(strict_types=1);
namespace Tests\Feature;

use App\Models\Notification;
use App\Repository\Eloquent\NotificationRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;
    private $repository, $testData = [
        'description' => "Lorem imsum test",
        'readed' => 1,
        'url_action' => "/test/12",
        'user_id' => 1,
        'author_id' => 1,
    ];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function factory(array $values = [])
    {
        $notification = Notification::factory()->create($values);
        $this->repository = new NotificationRepository($notification);
    }

    public function test_notifications_find()
    {
        $this->factory([
            'id' => 1
        ]);

        $notifcation = $this->repository->findOrFail(1);

        $this->assertFalse(empty($notifcation));
    }

    public function test_notifications_update()
    {
        $this->factory([
            'id' => 1
        ]);

        $notifcation = $this->repository->update($this->testData, 1);

        $this->assertFalse(empty($notifcation));
    }

    public function test_notifications_destroy()
    {
        $this->factory([
            'id' => 1
        ]);

        $destroyResult = $this->repository->destroy(1);

        $this->assertTrue($destroyResult);
    }

    public function test_notifications_get()
    {
        $this->factory();

        $notifications = $this->repository->get();
        $countOneModel = count($notifications) === 1;

        $this->assertTrue($countOneModel);
    }

    public function test_notifications_create()
    {
        $this->factory();

        $notification = $this->repository->create($this->testData);

        $this->assertFalse(empty($notification));
    }

    public function test_notifications_get_filters()
    {
        $this->factory();

        $this->repository->create($this->testData);
        $notifications = $this->repository->get($this->testData);
        $countOneModel = count($notifications) === 1;

        $this->assertTrue($countOneModel);
    }
}
