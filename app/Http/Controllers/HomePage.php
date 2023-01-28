<?php

namespace App\Http\Controllers;

use App\Repository\DayRepository;
use App\Repository\StatusRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomePage extends Controller
{
    private $dayRepository;
    public function __construct(StatusRepository $statusRepository, DayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
        $this->statusRepository = $statusRepository;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $date = date('d-m-Y');

        return View('home', [
            'dayActualy' => $this->dayRepository->findByDate($date),
            'status' => $this->statusRepository->findByDataAndUser(Auth::id(), $date)
        ]);
    }
}
