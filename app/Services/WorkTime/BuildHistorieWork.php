<?php
declare(strict_types=1);
namespace App\Services\WorkTime;

use App\Models\Historie;
use App\Models\User;
use App\Services\WorkTime\CalcualteWorkTime;

class BuildHistorieWork
{
    private $calculateUserTime;

    public function __construct(string $startTime, string $endTime, string $monthAndYear) {
        $this->calculateUserTime = new CalcualteWorkTime($startTime, $endTime, $monthAndYear);
    }

    /**
     * @param UserRepository $userRepository
     * @param array|string $
     * @return void
     */
    public function buildHistorieTime(array $idUser = []) {
        $newHistories = [];
        if (count($idUser) === 0) $users = User::get();
        else $users = User::find($idUser);

        foreach ($users as $user) $newHistories[] = $this->calculateUserTime->calculateUser($user);

        Historie::insert($newHistories);
    }
}