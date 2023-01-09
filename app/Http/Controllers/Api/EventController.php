<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventCreate;
use App\Http\Requests\EventFilter;
use App\Http\Requests\EventUpdate;
use App\Http\Resources\Event;
use App\Http\Resources\Events;
use App\Repository\EventRepository;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;

class EventController extends Controller
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    public function index(EventFilter $request) {
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
