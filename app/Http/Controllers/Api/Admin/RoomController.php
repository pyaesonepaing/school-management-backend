<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomStoreRequest;
use App\Http\Requests\RoomUpdateRequest;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json(Room::with('campus')->get());
    }

    public function store(RoomStoreRequest $request)
    {
        $room = Room::create($request->validated());
        return response()->json($room, 201);
    }

    public function show(Room $room)
    {
        return response()->json($room->load('campus'));
    }

    public function update(RoomUpdateRequest $request, Room $room)
    {
        $room->update($request->validated());
        return response()->json($room);
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(['message' => 'Room deleted']);
    }
}