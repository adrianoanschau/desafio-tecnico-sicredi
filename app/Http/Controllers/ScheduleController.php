<?php

namespace App\Http\Controllers;

use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        return response()->json(Schedule::all(), 200);
    }

    public function show(Schedule $schedule)
    {
        return response()->json($schedule, 200);
    }

    public function store()
    {
        $schedule = Schedule::create(request()->all());
        return response()->json($schedule, 201);
    }

    public function update(Schedule $schedule)
    {
        $schedule->update(request()->all());
        return response()->json($schedule, 200);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->json($schedule, 204);
    }
}
