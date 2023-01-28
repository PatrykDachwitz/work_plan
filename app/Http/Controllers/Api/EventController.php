<?php

namespace App\Http\Controllers\Api;

use App\Event\RegisterExitWork;
use App\Event\RegisterStartWork;
use App\Event\RegisterStatus;
use App\Event\UpdateIssetStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Create\Event as EventCreate;
use App\Http\Requests\Filters\Event as EventFilters;
use App\Http\Requests\Update\Event as EventUpdate;
use App\Http\Resources\Event;
use App\Http\Resources\Events;
use App\Repository\EventRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventController extends Controller
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    public function index(EventFilters $request) {
        $clearData = $request->validated();
        try {
            $events = $this->eventRepository->get($clearData);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Events($events), 200);
    }
    public function show(int $id) {
        try {
            $event = $this->eventRepository->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => 'Event not found'
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Event($event), 200);
    }
    public function store(EventCreate $request) {
        try {
            if (is_null($request->input('status_id', null))) {
                $statusId = (event(new RegisterStatus($request->validated())))[0];
            } else {
                $request->get('exitWork', false) ? event(new UpdateIssetStatus($request->validated())) : true;
                $request->get('startWork', false) ? event(new UpdateIssetStatus($request->validated())) : true;
            }

            $clearData = $request->only([
                'date',
                'hour',
                'user_id',
                'status_id',
                'description',
            ]);
            $clearData['status_id'] ?? $clearData['status_id'] = $statusId;

            $event = $this->eventRepository->create($clearData);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Event($event), 200);
    }
    public function update(EventUpdate $request, int $id) {
        $clearData = $request->validated();

        try {
            $event = $this->eventRepository->update($clearData, $id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => 'Event not found'
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json(new Event($event), 200);
    }
    public function destroy(int $id) {
        try {
            $this->eventRepository->destroy($id);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'msg' => 'Event not found'
                ], 404);
        } catch (Exception) {
            return response()
                ->json([
                    'msg' => 'Error server'
                ], 500);
        }

        return response()
            ->json([
                'msg' => "Event is deleted",
                'action' => action([$this::class, 'index'])
            ], 302);
    }
}
