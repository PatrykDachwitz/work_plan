<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Day>
 */
class DayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => date("d-m-Y"),
            'day_name' => 'Piątek',
            'free_day' => 0,
            'day' => date("d"),
            'month' => date("M"),
        ];
    }
}
