<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodeEnum;
use App\Http\Requests\StoreAssociateRequest;
use App\Http\Requests\UpdateAssociateRequest;
use App\Http\Resources\AssociateResource;
use App\Repositories\AssociateRepository;
use Illuminate\Http\JsonResponse;
use Exception;

class AssociateController extends Controller
{
    /** @var AssociateRepository */
    private $repository;

    /**
     * AssociateController constructor.
     * @param AssociateRepository $repository
     */
    public function __construct(AssociateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $associates = $this->repository->getAll();

        return response()->json(
            AssociateResource::collection($associates),
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
        $associate = $this->repository->findByID($id);

        return response()->json(new AssociateResource($associate), HttpStatusCodeEnum::SUCCESS);
    }

    /**
     * @param StoreAssociateRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StoreAssociateRequest $request)
    {
        $associate = $this->repository->create($request->all());

        return response()->json(new AssociateResource($associate), HttpStatusCodeEnum::CREATED);
    }

    /**
     * @param UpdateAssociateRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateAssociateRequest $request, int $id)
    {
        $this->repository->update($id, $request->all());
        $associate = $this->repository->findByID($id);

        return response()->json(new AssociateResource($associate), HttpStatusCodeEnum::SUCCESS);
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
}
