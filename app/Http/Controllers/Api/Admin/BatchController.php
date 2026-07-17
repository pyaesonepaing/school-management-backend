<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BatchStoreRequest;
use App\Http\Requests\BatchUpdateRequest;
use App\Models\Batch;

class BatchController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Batch::with(['level', 'campus', 'students']);
        
        if ($request->has('room_id')) {
            $query->whereHas('schedules', function ($q) use ($request) {
                $q->where('room_id', $request->room_id);
            });
        }
        
        return response()->json($query->get());
    }

    public function store(BatchStoreRequest $request)
    {
        $batch = Batch::create($request->validated());
        return response()->json($batch, 201);
    }

    public function show(Batch $batch)
    {
        return response()->json($batch->load(['level', 'campus', 'students']));
    }

    public function update(BatchUpdateRequest $request, Batch $batch)
    {
        $batch->update($request->validated());
        return response()->json($batch);
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return response()->json(['message' => 'Batch deleted']);
    }
}