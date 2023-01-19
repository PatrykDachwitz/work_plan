<?php

namespace App\Http\Controllers\Api;

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
        $clearData = $request->validated();
        try {
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
