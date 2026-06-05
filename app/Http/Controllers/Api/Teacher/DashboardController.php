<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $teacher = $request
            ->user()
            ->teacher;

        $batchIds = $teacher
            ->schedules()
            ->pluck('batch_id')
            ->unique();

        return response()->json([

            'total_batches' =>
                $batchIds->count(),

            'today_schedules' =>
                $teacher
                ->schedules()
                ->where(
                    'day_of_week',
                    strtolower(now()->format('l'))
                )
                ->with('batch')
                ->get(),

            'upcoming_exams' =>
                Exam::where(
                    'teacher_id',
                    $teacher->id
                )
                ->whereDate(
                    'exam_date',
                    '>=',
                    now()
                )
                ->take(5)
                ->get(),

            'assignments' =>
                Assignment::where(
                    'teacher_id',
                    $teacher->id
                )
                ->latest()
                ->take(5)
                ->get()

        ]);
    }
}