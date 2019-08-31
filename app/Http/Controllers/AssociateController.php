<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodeEnum;
use App\Models\Associate;
use Illuminate\Http\JsonResponse;

class AssociateController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Associate::all(), HttpStatusCodeEnum::SUCCESS);
    }

    /**
     * @param Associate $associate
     *
     * @return JsonResponse
     */
    public function show(Associate $associate)
    {
        return response()->json($associate, HttpStatusCodeEnum::SUCCESS);
    }

    /**
     * @return JsonResponse
     */
    public function store()
    {
        $associate = Associate::create(request()->all());
        return response()->json($associate, HttpStatusCodeEnum::CREATED);
    }

    /**
     * @param Associate $associate
     *
     * @return JsonResponse
     */
    public function update(Associate $associate)
    {
        $associate->update(request()->all());
        return response()->json($associate, HttpStatusCodeEnum::SUCCESS);
    }

    /**
     * @param Associate $associate
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Associate $associate)
    {
        $associate->delete();
        return response()->json(null, HttpStatusCodeEnum::NO_CONTENT);
    }
}
