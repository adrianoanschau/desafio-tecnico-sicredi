<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodeEnum;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(
            ScheduleResource::collection(Schedule::all()),
            HttpStatusCodeEnum::SUCCESS
        );
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function show(Schedule $schedule)
    {
        return response()->json(new ScheduleResource($schedule), HttpStatusCodeEnum::SUCCESS);
    }

    /**
     * @return JsonResponse
     */
    public function store()
    {
        $schedule = Schedule::create(request()->all());
        return response()->json(new ScheduleResource($schedule), HttpStatusCodeEnum::CREATED);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function update(Schedule $schedule)
    {
        $schedule->update(request()->all());
        return response()->json(new ScheduleResource($schedule), HttpStatusCodeEnum::SUCCESS);
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
        return response()->json(null, HttpStatusCodeEnum::NO_CONTENT);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function openSession(Schedule $schedule)
    {
        if (!is_null($schedule->currentSession)) {
            return response()->json([
                'message' => 'Esta pauta já possui uma sessão aberta.'
            ], HttpStatusCodeEnum::CONFLICT);
        }
        $schedule->sessions()->create();
        $schedule->refresh();
        return response()->json(
            new ScheduleResource($schedule),
            HttpStatusCodeEnum::SUCCESS
        );
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function closeSession(Schedule $schedule)
    {
        if (is_null($schedule->currentSession)) {
            return response()->json([
                'message' => 'Esta pauta não possui uma sessão aberta.'
            ], HttpStatusCodeEnum::NOT_FOUND);
        }
        $schedule->currentSession()->update([
            'closed_at' => Carbon::now(),
        ]);
        $schedule->refresh();
        return response()->json(
            new ScheduleResource($schedule),
            HttpStatusCodeEnum::SUCCESS
        );
    }
}
