<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use Illuminate\Http\JsonResponse;

class AssociateController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Associate::all(), 200);
    }

    /**
     * @param Associate $associate
     *
     * @return JsonResponse
     */
    public function show(Associate $associate)
    {
        return response()->json($associate, 200);
    }

    /**
     * @return JsonResponse
     */
    public function store()
    {
        $associate = Associate::create(request()->all());
        return response()->json($associate, 201);
    }

    /**
     * @param Associate $associate
     *
     * @return JsonResponse
     */
    public function update(Associate $associate)
    {
        $associate->update(request()->all());
        return response()->json($associate, 200);
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
        return response()->json($associate, 204);
    }
}
