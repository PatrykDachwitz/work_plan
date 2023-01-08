<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusDay extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        DB::table('statuses')->truncate();
        $userId = 1;

        for ($day_id = 1; $day_id < 20; $day_id++) {
            $date = date('Y-m-d', strtotime("+{$day_id} day"));
            $data[] = [
              'user_id' => $userId,
              'day_id' => $day_id,
              'time_start' => $date . " 7:05:01",
              'time_end' => $date . " 15:15:21",
              'status' => 'workDay',
              'accepted' => true,
              'accepted_user_id' => 2,
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
            ];
        }

        DB::table('statuses')->insertOrIgnore($data);
    }
}
