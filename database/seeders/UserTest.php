<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
        $faker = Factory::create();
        for ($i = 0; $i <= 10; $i++) {
            $users[] = [
                'first_name' => $faker->firstName,
                'email_company' => "testEmail@wp.pl",
                'password' => Hash::make('password'),
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
        DB::table('users')->insertOrIgnore($users);

    }
}
