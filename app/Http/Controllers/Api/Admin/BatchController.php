<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BatchStoreRequest;
use App\Http\Requests\BatchUpdateRequest;
use App\Models\Batch;

class BatchController extends Controller
{
    public function index()
    {
        // Return batches with related level, campus, and room
        return response()->json(Batch::with(['level', 'campus', 'room', 'students'])->get());
    }

    public function store(BatchStoreRequest $request)
    {
        $batch = Batch::create($request->validated());
        return response()->json($batch, 201);
    }

    public function show(Batch $batch)
    {
        return response()->json($batch->load(['level', 'campus', 'room', 'students']));
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