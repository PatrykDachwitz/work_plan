<?php

namespace Tests\Feature\Site;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $errorData, $correctData, $correctUpdateData, $userAdmin, $userSuperAdmin;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->userAdmin = User::factory()->create([
            'role_id' => 1
        ]);
        $this->userSuperAdmin = User::factory()->create([
            'role_id' => 2
        ]);
        $this->actingAs($user);

        $this->errorData = [
            'password' => 'łżęr1.',
            'password_confirmation' => 'łż/ęr',
            "first_name" => "/test. ę?>]",
            "last_name" => "/test",
            "email_company" => "testwp.pl",
            "email_private" => "testwp.pl",
            "number_phone" => "werte",
            "city" => "test,;'",
            "zip_code" => 'sd-123',
            "street" => "test,;'",
            "role_id" => 'test./',
            "group_id" => 'test./',
        ];

        $this->correctData = [
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
        $this->correctUpdateData = [
            "first_name" => "test",
            "last_name" => "test",
            "email_company" => "test2@wp.pl",
            "email_private" => "test@wp.pl",
            "number_phone" => "123123123",
            "city" => "test 12A",
            "zip_code" => "11-112",
            "street" => "test 12A",
        ];

        $this->errorUpdateData = [
            "email_company" => "test2wp.pl",
            "email_private" => "testwp.pl",
            "number_phone" => "123123123./",
            "zip_code" => "11-2",
        ];
    }

    public function testIndexUser()
    {
        $response = $this->get(route('user.index'));

        $response->assertStatus(200);
    }

    public function testCreateUserNotPermision()
    {
        $response = $this->get(route('user.create'));

        $response->assertStatus(403);
    }

    public function testCreateUserAdminPermision()
    {
        $response = $this->actingAs($this->userAdmin)
            ->get(route('user.create'));

        $response->assertStatus(403);
    }

    public function testCreateUser()
    {
        $response = $this->actingAs($this->userSuperAdmin)
            ->get(route('user.create'));

        $response->assertStatus(200);
    }

    public function testEditUserNotPromision()
    {
        $response = $this->get(route('user.edit', [
            'id' => 1
        ]));

        $response->assertStatus(403);
    }
    public function testEditUserNotPromisionNotHerGroup()
    {
        $user = User::factory()->create([
            'id' => 50,
            'role_id' => 0,
            "group_id" => 150
        ]);
        User::factory()->create([
            'id' => 51,
            'role_id' => 0,
            "group_id" => 150
        ]);

        $response = $this->actingAs($user)
            ->get(route('user.edit', [
            'id' => 51
        ]));

        $response->assertStatus(403);
    }

    public function testEditUserAdminPromisionNotHerGroup()
    {
        $user = User::factory()->create([
            'id' => 50,
            'role_id' => 1,
            "group_id" => 150
        ]);
        $response = $this->actingAs($user)
            ->get(route('user.edit', [
            'id' => 1
        ]));

        $response->assertStatus(403);
    }

    public function testEditUserHerGroupAdminPromision()
    {
        $user = User::factory()->create([
            'id' => 50,
            'role_id' => 1,
            "group_id" => 150
        ]);
        User::factory()->create([
            'id' => 51,
            'role_id' => 0,
            "group_id" => 150
        ]);
        $response = $this->actingAs($user)
            ->get(route('user.edit', [
            'id' => 51
        ]));

        $response->assertStatus(403);
    }

    public function testEditUserSuperAdminPromision()
    {
        $user = User::factory()->create([
            'id' => 50,
            'role_id' => 2,
            "group_id" => 149
        ]);
        User::factory()->create([
            'id' => 51,
            'role_id' => 0,
            "group_id" => 150
        ]);
        $response = $this->actingAs($user)
            ->get(route('user.edit', [
            'id' => 51
        ]));

        $response->assertStatus(200);
    }


    public function testShowUser()
    {
        $response = $this->get(route('user.show'));

        $response->assertStatus(200);
    }



    public function testCreateErrorDataOnRequestNotPermision()
    {
        $response = $this->post(route('user.register'), $this->correctData);

        $response->assertStatus(403);
    }
    public function testCreateErrorDataOnRequestNotPermisionAdmin()
    {
        $response = $this->actingAs($this->userAdmin)
            ->post(route('user.register'), $this->correctData);

        $response->assertStatus(403);
    }

    public function testCreateErrorDataOnRequest()
    {
        $response = $this->actingAs($this->userSuperAdmin)
        ->post(route('user.register'), $this->errorData);

        $response->assertSessionHasErrors([
            'password',
            "email_company",
            "email_private",
            "number_phone",
            "zip_code",
            "role_id",
            "group_id"
        ])->assertStatus(302);
    }

    public function testCreateCorrectDataOnRequest()
    {
        $response = $this->actingAs($this->userSuperAdmin)
        ->post(route('user.register'), $this->correctData);

        $searchData = $this->correctData;
        unset($searchData['password_confirmation']);
        unset($searchData['password']);

        $this->assertDatabaseHas('users', $searchData);
        $response->assertStatus(302);
    }

    public function testCreateCorrectDataOnRequestDuplicateCompanyMail()
    {
        User::factory()->create([
            'email_company' => 'test2@wp.pl'
        ]);

        $response = $this->actingAs($this->userSuperAdmin)
            ->post(route('user.register'), $this->correctData);
        $searchData = $this->correctData;
        unset($searchData['password_confirmation']);
        unset($searchData['password']);

        $this->assertDatabaseMissing('users', $searchData);
        $response->assertStatus(302)
        ->assertSessionHasErrors('email_company');
    }

    public function testCreateCorrectDataOnRequestNoneConfirmedPassword()
    {
        $searchData = $this->correctData;
        unset($searchData['password_confirmation']);
        $response = $this->actingAs($this->userSuperAdmin)
            ->post(route('user.register'), $searchData);

        $response->assertStatus(302)
        ->assertSessionHasErrors([
            'password'
        ]);
    }

    public function testUpdateErrorDataOnRequest()
    {
        $response = $this->actingAs($this->userSuperAdmin)
            ->post(route('user.update', [
            'id' => 1
        ]), $this->errorUpdateData);

        $response->assertSessionHasErrors([
            "email_company",
            "email_private",
            "number_phone",
            "zip_code",
        ])->assertStatus(302);
    }

    public function testUpdateCorrectDataOnRequest()
    {
        $response = $this->actingAs($this->userSuperAdmin)
            ->post(route('user.update', [
            'id' => 1
        ]), $this->correctUpdateData);

        $this->assertDatabaseHas('users', $this->correctUpdateData);
        $response->assertStatus(302);
    }

    public function testUpdateCorrectDataOnRequestAdminPermisionNotHerGroup()
    {
        $user = User::factory()->create([
           'role_id' => 1,
           'group_id' => 150
        ]);
        $response = $this->actingAs($user)
            ->post(route('user.update', [
            'id' => 1
        ]), $this->correctUpdateData);

        $response->assertStatus(403);
    }

    public function testUpdateCorrectDataOnRequestAdminPemisionHerGroup()
    {
        $user = User::factory()->create([
            'role_id' => 1,
            'group_id' => 150
        ]);
        User::factory()->create([
            'id' => 50,
            'role_id' => 0,
            'group_id' => 150
        ]);

        $response = $this->actingAs($user)
            ->post(route('user.update', [
            'id' => 50
        ]), $this->correctUpdateData);

        $response->assertStatus(403);
    }

    public function testUpdateWithDuplicateEmail()
    {
        User::factory()->create([
            'email_company' => 'test2@wp.pl'
        ]);

        $response = $this->actingAs($this->userSuperAdmin)
            ->post(route('user.update', [
            'id' => 1
        ]), $this->correctUpdateData);

        $this->assertDatabaseMissing('users', $this->correctUpdateData);
        $response->assertStatus(302)
        ->assertSessionHasErrors([
            'email_company'
        ]);
    }

    public function testUpdateWithDuplicateHerEmail()
    {
        User::factory()->create([
            'id' => 4,
            'email_company' => 'test2@wp.pl'
        ]);

        $response = $this->actingAs($this->userSuperAdmin)
            ->post(route('user.update', [
            'id' => 4
        ]), $this->correctUpdateData);

        $this->assertDatabaseHas('users', $this->correctUpdateData);
        $response->assertStatus(302)
            ->assertSessionDoesntHaveErrors();

    }

}
