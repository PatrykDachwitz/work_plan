<?php
declare(strict_types=1);
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    private const AVAILABLE_STATUS_DAY = [
        'holidayLeave',
        'workDay',
        'sickLeave',
        'delegation'
        ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 150),
            'day_id' => rand(1, 150),
            'hour_start' => date("H:i"),
            'hour_end' => date("H:i"),
            'date' => date("d-m-Y"),
            'status' => SELF::AVAILABLE_STATUS_DAY[array_rand(SELF::AVAILABLE_STATUS_DAY)],
        ];
    }
}
