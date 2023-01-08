<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusCreate;
use App\Http\Requests\StatusUpdate;
use App\Http\Resources\Statuses;
use App\Http\Resources\Status;
use App\Repository\StatusRepository;
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
        try {
            $statuses = $this->statusRepository->get();
        } catch (Exception) {
            return response()
                ->json([], 500);

        }
        return response()
            ->json(new Statuses($statuses), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusCreate $request)
    {
        $clearData = $request->validated();
        try {
            $status = $this->statusRepository->create($clearData);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error with add status to database'
                ], 500);
        }

        return response()
            ->json(new Status($status), 200);
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
            $status = $this->statusRepository->findOrFail($id);

            return response()
                ->json(new Status($status), 200);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => "Status not found"
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => "Error server"
                ], 500);
        }

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
    public function update(StatusUpdate $request, int $id)
    {
        $clearData = $request->validated();
        try{
            $status = $this->statusRepository->update($clearData, $id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => 'Status not found'
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error with update status day in database'
                ], 500);
        }
        return response()
            ->json(new Status($status), 200);
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
            $this->statusRepository->destroy($id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => 'Status not found'
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error with delete status in database'
                ], 500);
        }
        return response()
            ->json([
                'msg' => 'Status deleted on database',
                'url' => action([$this::class, 'index'])
            ], 302);
    }
}
