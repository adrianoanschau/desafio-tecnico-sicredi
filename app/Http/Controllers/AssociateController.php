<?php

namespace App\Http\Controllers;

use App\Models\Associate;

class AssociateController extends Controller
{
    public function index()
    {
        return Associate::all();
    }

    public function show(Associate $associate)
    {
        return $associate;
    }

    public function store()
    {
        $associate = Associate::create(request()->all());
        return $associate;
    }

    public function update(Associate $associate)
    {
        $associate->update(request()->all());
        return $associate;
    }

    public function destroy(Associate $associate)
    {
        $associate->delete();
        return $associate;
    }
}
