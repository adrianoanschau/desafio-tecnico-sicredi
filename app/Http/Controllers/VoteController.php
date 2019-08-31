<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodeEnum;
use App\Http\Requests\VoteResultRequest;
use App\Repositories\ScheduleRepository;
use App\Repositories\VoteRepository;
use Illuminate\Http\JsonResponse;
use Exception;

class VoteController extends Controller
{
    /** @var VoteRepository */
    private $repository;

    /** @var ScheduleRepository */
    private $scheduleRepository;

    /**
     * VoteController constructor.
     * @param VoteRepository $repository
     * @param ScheduleRepository $scheduleRepository
     */
    public function __construct(VoteRepository $repository, ScheduleRepository $scheduleRepository)
    {
        $this->repository = $repository;
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * @param VoteResultRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function result(VoteResultRequest $request)
    {
        $schedule = $this->scheduleRepository->findByID($request->input('schedule_id'));

        $result = $this->repository->getResult($schedule);

        return response()->json($result, HttpStatusCodeEnum::SUCCESS);

    }
}
