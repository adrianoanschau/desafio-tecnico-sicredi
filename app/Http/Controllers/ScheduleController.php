<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodeEnum;
use App\Http\Requests\OpenScheduleSessionRequest;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Requests\VoteScheduleSessionRequest;
use App\Http\Resources\ScheduleResource;
use App\Repositories\AssociateRepository;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /** @var ScheduleRepository */
    private $repository;

    /** @var AssociateRepository */
    private $associateRepository;

    /**
     * ScheduleController constructor.
     *
     * @param ScheduleRepository $repository
     * @param AssociateRepository $associateRepository
     */
    public function __construct(ScheduleRepository $repository, AssociateRepository $associateRepository)
    {
        $this->repository = $repository;
        $this->associateRepository = $associateRepository;
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
     * @param StoreScheduleRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreScheduleRequest $request)
    {
        $schedule = $this->repository->create($request->all());

        return response()->json(new ScheduleResource($schedule), HttpStatusCodeEnum::CREATED);
    }

    /**
     * @param UpdateScheduleRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateScheduleRequest $request, int $id)
    {
        $this->repository->update($id, $request->all());
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
     * @param OpenScheduleSessionRequest $request
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function openSession(OpenScheduleSessionRequest $request, int $id)
    {
        $schedule = $this->repository->openSession($id, $request->input('time'));

        return response()->json(
            new ScheduleResource($schedule),
            HttpStatusCodeEnum::SUCCESS
        );
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function closeSession(int $id)
    {
        $schedule = $this->repository->closeSession($id);

        return response()->json(
            new ScheduleResource($schedule),
            HttpStatusCodeEnum::SUCCESS
        );
    }

    /**
     * @param VoteScheduleSessionRequest $request
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function vote(VoteScheduleSessionRequest $request, int $id)
    {
        if ($request->has('associate_id')) {
            $associate = $this->associateRepository
                ->findByID($request->input('associate_id'));
        } else if ($request->has('associate.document')) {
            $associate = $this->associateRepository->findByDocument($request->input('associate.document'));
            if (is_null($associate) && $request->has('associate.name')) {
                $associate = $this->associateRepository->create($request->input('associate'));
            }
        }

        $schedule = $this->repository->vote($id, [
            'associate' => $associate,
            'option' => $request->input('option'),
        ]);

        return response()->json(
            new ScheduleResource($schedule),
            HttpStatusCodeEnum::SUCCESS
        );
    }
}
