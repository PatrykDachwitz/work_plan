<?php

namespace Site;

use App\Models\User;
use Tests\TestCase;
use function route;

class LoginPageTest extends TestCase
{
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserIsNotLogin()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function testUserIsLogin()
    {
        $response = $this->actingAs($this->user)
            ->post(route('login'));

        $response->assertRedirectToRoute('dashboard');
    }

    public function testLoginUser()
    {
        $response = $this->post(route('login'), [
            'email_company' => 'testEmail@wp.pl',
            'password' => 'password'
        ]);

        $response->assertRedirectToRoute('dashboard');
    }

    public function testFailedPassword()
    {
        $response = $this->post(route('login'), [
            'email_company' => 'testEmail@wp.pl',
            'password' => 'password12'
        ]);

        $response->assertSessionHasErrors('email_company');
    }

    public function testFailedEmail()
    {
        $response = $this->post(route('login'), [
            'email_company' => 'testEmail12@wp.pl',
            'password' => 'password'
        ]);

        $response->assertSessionHasErrors('email_company');
    }

    public function testLogaoutNotLogedUser()
    {
        $response = $this->get(route('logout'));

        $response->assertRedirectToRoute('login');
    }
    public function testLogaoutLogedUser()
    {
        $response = $this->actingAs($this->user)
            ->get(route('logout'));

        $response->assertRedirectToRoute('login');
    }
}
