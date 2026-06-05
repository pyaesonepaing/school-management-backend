<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function mark(
        Request $request,
        Schedule $schedule
    )
    {
        $request->validate([

            'attendance_date' => 'required|date',

            'students' => 'required|array',

        ]);

        foreach ($request->students as $student) {

            Attendance::updateOrCreate(

                [

                    'schedule_id' => $schedule->id,

                    'student_id' => $student['student_id'],

                    'attendance_date' =>
                        $request->attendance_date

                ],

                [

                    'status' =>
                        $student['status'],

                    'remark' =>
                        $student['remark'] ?? null

                ]

            );
        }

        return response()->json([
            'message' =>
                'Attendance saved successfully.'
        ]);
    }
}