<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LevelStoreRequest;
use App\Http\Requests\LevelUpdateRequest;
use App\Models\Level;

class LevelController extends Controller
{
    public function index()
    {
        return response()->json(Level::all());
    }

    public function store(LevelStoreRequest $request)
    {
        $level = Level::create($request->validated());
        return response()->json($level, 201);
    }

    public function show(Level $level)
    {
        return response()->json($level);
    }

    public function update(LevelUpdateRequest $request, Level $level)
    {
        $level->update($request->validated());
        return response()->json($level);
    }

    public function destroy(Level $level)
    {
        $level->delete();
        return response()->json(['message' => 'Level deleted']);
    }
}