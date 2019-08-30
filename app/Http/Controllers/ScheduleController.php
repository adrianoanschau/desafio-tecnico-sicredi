<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(ScheduleResource::collection(Schedule::all()), 200);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function show(Schedule $schedule)
    {
        return response()->json(new ScheduleResource($schedule), 200);
    }

    /**
     * @return JsonResponse
     */
    public function store()
    {
        $schedule = Schedule::create(request()->all());
        return response()->json(new ScheduleResource($schedule), 201);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function update(Schedule $schedule)
    {
        $schedule->update(request()->all());
        return response()->json(new ScheduleResource($schedule), 200);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->json(new ScheduleResource($schedule), 204);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function openSession(Schedule $schedule)
    {
        if (!is_null($schedule->currentSession)) {
            return response()->json([ 'message' => 'Esta pauta já possui uma sessão aberta.' ], 409);
        }
        $schedule->sessions()->create();
        return response()->json(new ScheduleResource($schedule), 200);
    }
}
