<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationCreate;
use App\Http\Requests\NotificationFilter;
use App\Http\Requests\NotificationUpdate;
use App\Http\Resources\Notification;
use App\Http\Resources\Notifications;
use App\Repository\NotificationRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;

class NotificationController extends Controller
{

    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository) {
        $this->notificationRepository = $notificationRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NotificationFilter $request)
    {
        $clearData = $request->validated();
        try {
            $notifications = $this->notificationRepository->get($clearData);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }
        return response()
            ->json(new Notifications($notifications), 200);
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
    public function store(NotificationCreate $request)
    {
        $clearData = $request->validated();

        try {
            $notification = $this->notificationRepository->create($clearData);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Notification($notification), 200);
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
            $notification = $this->notificationRepository->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => 'Notification not found'
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Notification($notification), 200);
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
    public function update(NotificationUpdate $request, int $id)
    {
        $clearData = $request->validated();

        try {
            $notification = $this->notificationRepository->update($clearData, $id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => 'Notification not found'
                ], 404);
        }catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Notification($notification), 200);
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
            $this->notificationRepository->destroy($id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => 'Notification not found'
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json([
                'msg' => 'Notification is deleted',
                'action' => action([$this::class, 'index'])
            ], 302);
    }
}
