<?php

namespace Repository;

use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;
    protected $repository, $faker, $userData, $searchUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $user = User::factory()->create();
        $this->repository = new UserRepository($user);

        $this->userData = [
            'password' => uniqid(),
            'first_name' => $this->faker->firstName,
            'email_company' => $this->faker->email,
            'last_name' => $this->faker->lastName,
            'email_private' => $this->faker->safeEmail,
            'city' => $this->faker->city,
            'zip_code' => $this->faker->postcode,
            'street' => $this->faker->streetAddress,
            'number_phone' => rand(111111111,999999999),
        ];

        $this->searchUser = [
            'first_name' => $this->userData['first_name'],
            'email_company' => $this->userData['email_company'],
            'last_name' => $this->userData['last_name'],
            'email_private' => $this->userData['email_private'],
            'city' => $this->userData['city'],
            'zip_code' => $this->userData['zip_code'],
            'street' => $this->userData['street'],
            'number_phone' => $this->userData['number_phone'],
        ];
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $this->repository->create($this->userData);

        $this->assertDatabaseHas('users', $this->searchUser);
    }

    public function testUserShowById()
    {

        User::factory()->create([
            'id' => 4,
        ]);

        $user = $this->repository->findOrFail(4);

        $this->assertFalse(empty($user));
    }

    public function testUserShowByToken()
    {
        $tokenApi = uniqid();
        User::factory()->create([
            'token_api' => $tokenApi,
        ]);

        $user = $this->repository->findByToken($tokenApi);
        $this->assertFalse(empty($user));
    }

    public function testUserUpdate()
    {
        User::factory()->create([
            'id' => 3,
        ]);


        $user = $this->repository->update($this->userData, 3);

        $this->assertDatabaseHas('users', $this->searchUser);
    }

    public function testUserGet()
    {

        User::factory()
            ->count(3)
            ->create();

        $users = $this->repository->get();
        $findGoodCountRaw = count($users) === 4;

        $this->assertTrue($findGoodCountRaw);
    }
}
