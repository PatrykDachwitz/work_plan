<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenereDays extends Seeder
{
    private const TRANSLATE_DAY = [
        'Mon' => 'Poniedziałek',
        'Tue' => 'Wtorek',
        'Wed' => 'Środa',
        'Thu' => 'Czwartek',
        'Fri' => 'Piątek',
        'Sat' => 'Sobota',
        'Sun' => 'Niedziela',
        ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    private function isWeekend(string $day) {
        if (in_array($day, [
            'Sat',
            'Sun',
        ])) {
            return true;
        } else {
            return false;
        }
    }

    public function run()
    {
        DB::table('days')->truncate();

        $dates = [];

        for ($i = 1; $i < 31; $i++) {
            $dayText = date("D", strtotime("+{$i} day"));

            $dates[] = [
              'date' => date('d-m-Y', strtotime("+{$i} day")),
              'day_name' => SELF::TRANSLATE_DAY[$dayText],
              'free_day' => $this->isWeekend($dayText),
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
            ];
        }

        DB::table('days')->insertOrIgnore($dates);
    }
}
