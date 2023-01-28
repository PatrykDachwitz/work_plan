<?php

namespace Tests\Feature\Site;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserNotAuthTest extends TestCase
{
    protected $updateData, $storeData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->updateData = [
            'password' => "test1234",
            'password_confirmation' => "test1234",
            "first_name" => "test",
            "last_name" => "test",
            "email_company" => "test2@wp.pl",
            "email_private" => "test@wp.pl",
            "number_phone" => "123123123",
            "city" => "test 12A",
            "zip_code" => "11-112",
            "street" => "test 12A",
            "role_id" => 1,
            "group_id" => 1,
        ];
        $this->storeData = [
            "first_name" => "test",
            "last_name" => "test",
            "email_company" => "test2@wp.pl",
            "email_private" => "test@wp.pl",
            "number_phone" => "123123123",
            "city" => "test 12A",
            "zip_code" => "11-112",
            "street" => "test 12A",
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexUser()
    {
        $response = $this->get(route('user.index'));

        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }

    public function testStoreUser()
    {
        $response = $this->get(route('user.create'));

        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }
    public function testUpdateViewUser()
    {
        $response = $this->get(route('user.edit', [
            'id' => 1
        ]));

        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }
    public function testShowUser()
    {
        $response = $this->get(route('user.show', [
            'id' => 1
        ]));

        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }

    public function testRegisterUser()
    {
        $response = $this->post(route('user.register'), $this->storeData);


        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }

    public function testUpdateUser()
    {
        $response = $this->post(route('user.update', [
            'id' => 1
        ]), $this->updateData);


        $response->assertStatus(302)
        ->assertRedirect(route('login'));
    }
}
