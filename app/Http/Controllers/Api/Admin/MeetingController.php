<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingStoreRequest;
use App\Http\Requests\MeetingUpdateRequest;
use App\Models\Meeting;

class MeetingController extends Controller
{
    public function index()
    {
        return Meeting::with([
            'batch.level',
            'batch.campus'
        ])->get();
    }

    public function store(
        MeetingStoreRequest $request
    ) {
        $meeting = Meeting::create(
            $request->validated()
        );

        return response()->json(
            $meeting,
            201
        );
    }

    public function show(
        Meeting $meeting
    ) {
        return $meeting->load([
            'batch.level',
            'batch.campus'
        ]);
    }

    public function update(
        MeetingUpdateRequest $request,
        Meeting $meeting
    ) {
        $meeting->update(
            $request->validated()
        );

        return $meeting;
    }

    public function destroy(
        Meeting $meeting
    ) {
        $meeting->delete();

        return response()->json([
            'message' => 'Meeting deleted.'
        ]);
    }
}