<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Schedule::all(), 200);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function show(Schedule $schedule)
    {
        return response()->json($schedule, 200);
    }

    /**
     * @return JsonResponse
     */
    public function store()
    {
        $schedule = Schedule::create(request()->all());
        return response()->json($schedule, 201);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function update(Schedule $schedule)
    {
        $schedule->update(request()->all());
        return response()->json($schedule, 200);
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
        return response()->json($schedule, 204);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function openSession(Schedule $schedule)
    {
        $schedule->sessions()->create();
        return response()->json($schedule, 200);

    }
}
