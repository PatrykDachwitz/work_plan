<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => \Faker\Factory::create()->text(255),
            'readed' => rand(0, 1),
            'url_action' => "/test/12",
            'user_id' => 1,
            'author_id' => 1,
        ];
    }
}
