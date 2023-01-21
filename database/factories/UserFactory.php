<?php
declare(strict_types=1);
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;


    public function definition()
    {
        $faker = Faker::create();
        return [
            'first_name' => $faker->firstName,
            'email_company' => $faker->email,
            'password' => Hash::make(uniqid()),
            'last_name' => $faker->lastName,
            'email_private' => $faker->safeEmail,
            'city' => $faker->city,
            'zip_code' => $faker->postcode,
            'street' => $faker->streetAddress,
            'number_phone' => rand(111111111,999999999),
            'token_api' => uniqid(),
            'group_id' => rand(0,4),
            'role_id' => 0
        ];
    }
}
