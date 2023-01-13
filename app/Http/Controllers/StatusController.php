<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusCreate;
use App\Repository\DayRepository;
use App\Repository\StatusRepository;
use App\Services\Status\ManyStatuses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;

class StatusController extends Controller
{
    protected $statusRepository;

    public function __construct(StatusRepository $statusRepository) {
        $this->statusRepository = $statusRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $firstDay = date('d-m-Y');
        $lastDayView = date('d-m-Y', strtotime('-50 day'));

        return view('days.index', [
            'days' => $this->statusRepository->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(DayRepository $dayRepository)
    {
        return view('days.create', [
            'days' => $dayRepository->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusCreate $request, ManyStatuses $statuses)
    {
        try {
            $clearData = $request->validated();
            $statuses->insert($clearData);
        } catch (Exception) {
            return redirect()
                ->route('day.show', ['day' => 1])
                ->with('error', "Error udpdate free day");

        }
        return redirect()
            ->route('calendar.index')
            ->with('success', "Poprawnie zaktualizowano Stronę");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $day = $this->statusRepository->findOrFail($id);
         //   dd($day);
        } catch (ModelNotFoundException) {
            abort(404);
        }
        return View('days.show', [
            'day' => $day
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
