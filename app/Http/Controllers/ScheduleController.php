<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodeEnum;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Exception;

class ScheduleController extends Controller
{
    /** @var ScheduleRepository */
    private $repository;

    /**
     * ScheduleController constructor.
     *
     * @param ScheduleRepository $repository
     */
    public function __construct(ScheduleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $schedules = $this->repository->getAll();

        return response()->json(
            ScheduleResource::collection($schedules),
            HttpStatusCodeEnum::SUCCESS
        );
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $schedule = $this->repository->findByID($id);

        return response()->json(new ScheduleResource($schedule), HttpStatusCodeEnum::SUCCESS);
    }

    /**
     * @return JsonResponse
     */
    public function store()
    {
        $schedule = $this->repository->create(request()->all());

        return response()->json(new ScheduleResource($schedule), HttpStatusCodeEnum::CREATED);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(int $id)
    {
        $this->repository->update($id, request()->all());
        $schedule = $this->repository->findByID($id);

        return response()->json(new ScheduleResource($schedule), HttpStatusCodeEnum::SUCCESS);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        $this->repository->delete($id);

        return response()->json(null, HttpStatusCodeEnum::NO_CONTENT);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function openSession(int $id)
    {
        try {
            $schedule = $this->repository->openSession($id);

            return response()->json(
                new ScheduleResource($schedule),
                HttpStatusCodeEnum::SUCCESS
            );
        } catch(Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function closeSession(int $id)
    {
        try {
            $schedule = $this->repository->closeSession($id);

            return response()->json(
                new ScheduleResource($schedule),
                HttpStatusCodeEnum::SUCCESS
            );
        } catch(Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }
}
