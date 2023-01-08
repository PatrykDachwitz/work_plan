<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DayCreate;
use App\Http\Requests\DayFilter;
use App\Http\Requests\DayUpdate;
use App\Http\Resources\Day;
use App\Http\Resources\Days;
use App\Repository\DayRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;

class DaysController extends Controller
{

    private $dayRepository;

    public function __construct(DayRepository $dayRepository) {
        $this->dayRepository = $dayRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DayFilter $request)
    {
        $filters = $request->validated();
        $days = $this->dayRepository->get($filters);
        return response()
            ->json(new Days($days), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DayCreate $request)
    {
        $clearData = $request->validated();
        try {
            $day = $this->dayRepository->create($clearData);
        } catch (Exception) {
            return response()
                ->json([
                  'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Day($day), 200);
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
            $day = $this->dayRepository->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()
            ->json([
                'msg' => 'Day not found'
            ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Day($day), 200);
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
    public function update(DayUpdate $request,int $id)
    {
        $clearData = $request->validated();

        try {
            $day = $this->dayRepository->update($clearData, $id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => "Day not found"
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Day($day), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->dayRepository->destroy($id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => "Day not found"
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json([
                'msg' => "Day is deleted on database",
                'url' => action([$this::class, 'index'])
            ], 302);
    }
}
