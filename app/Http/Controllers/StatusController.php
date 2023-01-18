<?php

namespace App\Http\Controllers;

use App\Http\Requests\Create\Status as StatusCreate;
use App\Repository\DayRepository;
use App\Repository\StatusRepository;
use App\Services\Status\ManyStatuses;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    private const DAYS_AHEAD = 10;
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

        $filters = [
            'user_id' => Auth::id(),
            'time_start' => [
                'value' => date('Y-m-d', strtotime("+" . SELF::DAYS_AHEAD . " day")) . " 23:59:59",
                'type' => "<="
            ]
        ];
        $limit = 10;

        return view('days.index', [
            'days' => $this->statusRepository->get($filters, $limit),
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
