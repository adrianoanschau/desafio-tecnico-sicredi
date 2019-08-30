<?php

namespace App\Http\Controllers;

use App\Models\Associate;

class AssociateController extends Controller
{
    public function index()
    {
        return response()->json(Associate::all(), 200);
    }

    public function show(Associate $associate)
    {
        return response()->json($associate, 200);
    }

    public function store()
    {
        $associate = Associate::create(request()->all());
        return response()->json($associate, 201);
    }

    public function update(Associate $associate)
    {
        $associate->update(request()->all());
        return response()->json($associate, 200);
    }

    public function destroy(Associate $associate)
    {
        $associate->delete();
        return response()->json($associate, 204);
    }
}
