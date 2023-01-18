<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->truncate();

        $data = [];

        for ($i = 1; $i < 15; $i++) {
            $data[] = [
                'user_id' => 1,
                'status_id' => $i,
                'date' => Carbon::now(),
            ];
        }

        DB::table('events')->insertOrIgnore($data);
    }
}
