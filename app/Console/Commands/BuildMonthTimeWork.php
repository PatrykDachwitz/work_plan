<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repository\Eloquent\DayRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\HistoriesRepository;
use App\Services\WorkTime\BuildHistorieWork;
use Illuminate\Console\Command;

class BuildMonthTimeWork extends Command
{
    protected $userRepository;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work-time:month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build month work time for users';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $monthAndYear = date('m-Y');
        $startDate = '01-' . $monthAndYear;
        $endDate = '31-' . $monthAndYear;

        $buildHistories = new BuildHistorieWork($startDate, $endDate, $monthAndYear);
        $buildHistories->buildHistorieTime();

        return Command::SUCCESS;
    }
}
