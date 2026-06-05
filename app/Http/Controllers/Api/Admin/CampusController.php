<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampusStoreRequest;
use App\Http\Requests\CampusUpdateRequest;
use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index()
    {
        return response()->json(Campus::all());
    }

    public function store(CampusStoreRequest $request)
    {
        $campus = Campus::create($request->validated());

        return response()->json($campus, 201);
    }

    public function show(Campus $campus)
    {
        return response()->json($campus);
    }

    public function update(CampusUpdateRequest $request, Campus $campus)
    {
        $campus->update($request->validated());

        return response()->json($campus);
    }

    public function destroy(Campus $campus)
    {
        $campus->delete();

        return response()->json([
            'message' => 'Campus deleted'
        ]);
    }
}