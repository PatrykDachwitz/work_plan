<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repository\Eloquent\DayRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\HistoriesRepository;
use Illuminate\Console\Command;

class BuildMonthTimeWork extends Command
{
    protected $userRepository;
    private const  WORK_DAY_HOUR = 8;

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

    private function getCountWorkDay(DayRepository $dayRepository) {
        $filters = [
            'date' => [[
                'value' => '01-' . date('m-Y'),
                'type' => '>=',
            ],[
                'value' => '31-' . date('m-Y'),
                'type' => '<=',
            ]],
            'free_day' => [
                'value' => 0,
                'type' => '==',
            ]
        ];

        $countWorkDays = $dayRepository->get($filters);

        return count($countWorkDays);
    }

    public function buildUserTime(User $user, int $monthHour) {
        return [
            'date' => date('m-Y'),
            'user_id' => $user->id,
            'holidays_time' => 0,
            'delegation_time' => 0,
            'sick_leave' => 0,
            'work_time' => 0,
            'completely_available_time' => $monthHour,
        ];
    }

    public function handle(UserRepository $userRepository, DayRepository $dayRepository, HistoriesRepository $historiesRepository)
    {
        $newHistories = [];
        $users = $userRepository->get();
        $countWorkDay = ($this->getCountWorkDay($dayRepository)) * SELF::WORK_DAY_HOUR;
        foreach ($users as $user) {
            $newHistories[] = $this->buildUserTime($user, $countWorkDay);
        }
        $historiesRepository->create($newHistories);
        dd($newHistories);
        return Command::SUCCESS;
    }
}
