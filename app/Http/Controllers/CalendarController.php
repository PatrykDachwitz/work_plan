<?php

namespace App\Http\Controllers;

use App\Repository\DayRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    private $dayRepository;

    public function __construct(DayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return View('calendar.index', [
            'days' => $this->dayRepository->getWithUserStatus(Auth::id())
        ]);
    }
}
