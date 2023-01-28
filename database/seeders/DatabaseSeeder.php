<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           // GenereDays::class,
          //  StatusDay::class,
            UserTest::class,
        ]);
        // \App\Models\UserRole::factory(10)->create();

        // \App\Models\UserRole::factory()->create([
        //     'name' => 'Test UserRole',
        //     'email' => 'test@example.com',
        // ]);
    }
}
