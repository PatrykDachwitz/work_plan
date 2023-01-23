<?php
declare(strict_types=1);
namespace Site;

use App\Models\User;
use Tests\TestCase;
use function route;

class DashBoardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDashboardNotLoginClient()
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirectToRoute('login');
    }

    public function testDashboardLoginClient()
    {
        $user = User::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('dashboard'));

        $response->assertStatus(200);
    }

}
