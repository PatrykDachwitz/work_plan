<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Create\Status;
use App\Http\Requests\Filters\Status;
use App\Http\Requests\Update\Status;
use App\Http\Resources\Status;
use App\Http\Resources\Statuses;
use App\Repository\StatusRepository;
use App\Repository\UserApi;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
    public function index(Status $request)
    {
        $filters = $request->validated();

        try {
            $statuses = $this->statusRepository->get($filters);
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
    public function store(Status $request)
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
            ->json(['msg' => 'succes'], 200);
            //->json(new Status($status), 200);
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
    public function update(Status $request, UserApi $userRepository, int $id)
    {
        $clearData = $request->validated();
        $tokenApi = $clearData['token_api'];

        try{
            $status = $this->statusRepository->findOrFail($id);
            $user = $userRepository->findByToken($tokenApi);
            $employee = $userRepository->findOrFail($status->user_id);
            Auth::login($user);

            if (!Gate::any('userChangePermissions', [$user, $employee])) {
                return response()
                    ->json([
                        'msg' => 'You not have promision for update user'
                    ], 403);
            }

            $clearData['accepted_user_id'] = Auth::id();
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
