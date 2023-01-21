<?php
declare(strict_types=1);
namespace Tests\Feature;

use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_create()
    {
        $faker = Factory::create();
        $testData = [
            'password' => uniqid(),
            'first_name' => $faker->firstName,
            'email_company' => $faker->email,
            'last_name' => $faker->lastName,
            'email_private' => $faker->safeEmail,
            'city' => $faker->city,
            'zip_code' => $faker->postcode,
            'street' => $faker->streetAddress,
            'number_phone' => rand(111111111,999999999),
        ];
        $users = User::factory()->create();

        $repository = new UserRepository($users);
        $user = $repository->create($testData);

        $this->assertFalse(empty($user));
    }

    public function test_user_show()
    {
        $faker = Factory::create();
        $users = User::factory()->create([
            'id' => 1,
        ]);

        $repository = new UserRepository($users);
        $user = $repository->findOrFail(1);

        $this->assertFalse(empty($user));
    }

    public function test_user_show_by_token()
    {
        $tokenApi = uniqid();
        $users = User::factory()->create([
            'token_api' => $tokenApi,
        ]);

        $repository = new UserRepository($users);
        $user = $repository->findByToken($tokenApi);

        $this->assertFalse(empty($user));
    }

    public function test_user_update()
    {
        $faker = Factory::create();
        $testData = [
            'first_name' => $faker->firstName,
            'email_company' => $faker->email,
            'last_name' => $faker->lastName,
            'email_private' => $faker->safeEmail,
            'city' => $faker->city,
            'zip_code' => $faker->postcode,
            'street' => $faker->streetAddress,
            'number_phone' => rand(111111111,999999999),
        ];
        $users = User::factory()->create([
            'id' => 1,
        ]);

        $repository = new UserRepository($users);

        $user = $repository->update($testData, 1);

        $this->assertFalse(empty($user));
    }

    public function test_user_get()
    {

        $users = User::factory()->create();

        $repository = new UserRepository($users);

        $users = $repository->get();
        $findGoodCountRaw = count($users) === 1;

        $this->assertTrue($findGoodCountRaw);
    }


}
