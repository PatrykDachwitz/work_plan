<?php
declare(strict_types=1);
namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'date' => date('d-m-Y'),
            'hour' => date('H:i'),
            'user_id' => 1,
            'status_id' => 1,
            'description' => $faker->text(255),
        ];
    }
}
