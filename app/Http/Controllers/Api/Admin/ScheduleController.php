<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        return response()->json(
            Schedule::with([
                'batch',
                'teacher.user',
                'campus',
                'room'
            ])->get()
        );
    }

    public function store(ScheduleStoreRequest $request)
    {
        $data = $request->validated();

        // Room Conflict
        $roomConflict = $this->hasTimeConflict(
            Schedule::where('room_id', $data['room_id'])
                ->where('day_of_week', $data['day_of_week']),
            $data['start_time'],
            $data['end_time']
        );

        if ($roomConflict) {
            return response()->json([
                'message' => 'Room schedule conflict detected.'
            ], 422);
        }

        // Teacher Conflict
        $teacherConflict = $this->hasTimeConflict(
            Schedule::where('teacher_id', $data['teacher_id'])
                ->where('day_of_week', $data['day_of_week']),
            $data['start_time'],
            $data['end_time']
        );

        if ($teacherConflict) {
            return response()->json([
                'message' => 'Teacher schedule conflict detected.'
            ], 422);
        }

        // Batch Conflict
        $batchConflict = $this->hasTimeConflict(
            Schedule::where('batch_id', $data['batch_id'])
                ->where('day_of_week', $data['day_of_week']),
            $data['start_time'],
            $data['end_time']
        );

        if ($batchConflict) {
            return response()->json([
                'message' => 'Batch schedule conflict detected.'
            ], 422);
        }

        $schedule = Schedule::create($data);

        return response()->json(
            $schedule->load([
                'batch',
                'teacher.user',
                'campus',
                'room'
            ]),
            201
        );
    }

    public function show(Schedule $schedule)
    {
        return response()->json(
            $schedule->load([
                'batch',
                'teacher.user',
                'campus',
                'room'
            ])
        );
    }

    public function update(
        ScheduleUpdateRequest $request,
        Schedule $schedule
    ) {
        $data = $request->validated();

        // Room Conflict
        $roomConflict = $this->hasTimeConflict(
            Schedule::where('id', '!=', $schedule->id)
                ->where('room_id', $data['room_id'])
                ->where('day_of_week', $data['day_of_week']),
            $data['start_time'],
            $data['end_time']
        );

        if ($roomConflict) {
            return response()->json([
                'message' => 'Room schedule conflict detected.'
            ], 422);
        }

        // Teacher Conflict
        $teacherConflict = $this->hasTimeConflict(
            Schedule::where('id', '!=', $schedule->id)
                ->where('teacher_id', $data['teacher_id'])
                ->where('day_of_week', $data['day_of_week']),
            $data['start_time'],
            $data['end_time']
        );

        if ($teacherConflict) {
            return response()->json([
                'message' => 'Teacher schedule conflict detected.'
            ], 422);
        }

        // Batch Conflict
        $batchConflict = $this->hasTimeConflict(
            Schedule::where('id', '!=', $schedule->id)
                ->where('batch_id', $data['batch_id'])
                ->where('day_of_week', $data['day_of_week']),
            $data['start_time'],
            $data['end_time']
        );

        if ($batchConflict) {
            return response()->json([
                'message' => 'Batch schedule conflict detected.'
            ], 422);
        }

        $schedule->update($data);

        return response()->json(
            $schedule->load([
                'batch',
                'teacher.user',
                'campus',
                'room'
            ])
        );
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return response()->json([
            'message' => 'Schedule deleted successfully.'
        ]);
    }

    private function hasTimeConflict(
        $query,
        string $startTime,
        string $endTime
    ): bool {
        return $query
            ->where(function ($q) use ($startTime, $endTime) {

                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);

            })
            ->exists();
    }
}