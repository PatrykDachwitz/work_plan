<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->withoutExceptionHandling();
        $users = User::factory()->create([
            'role_id' => 3
        ]);

        $this->actingAs($users)->post('/user/register',[
            'password' => "test1234",
            'password_confirmation' => "test1234",
            "first_name" => 'Patryk',
            "last_name" => 'Dachwitz',
            "email_company" => 'email@wp.pl',
            "email_private" => 'emailCompany@wp.pl',
            "number_phone" => "123123123",
            "city" => "test",
            "zip_code" => '66-110',
            "street" => 'test',
            "role_id" => "1",
            "group_id" => "1",
        ]);

        $this->assertDatabaseHas('users', [
            "first_name" => 'Patryk',
            "last_name" => 'Dachwitz',
            "email_company" => 'email@wp.pl',
            "email_private" => 'emailCompany@wp.pl',
            "number_phone" => 123123123,
            "city" => "test",
            "zip_code" => '66-110',
            "street" => 'test',
            "role_id" => 1,
            "group_id" => 1,
        ]);

    }
}
