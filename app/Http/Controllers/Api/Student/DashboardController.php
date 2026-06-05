<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Blog;
use App\Models\Exam;
use App\Models\Meeting;
use App\Models\Schedule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $student = $request
            ->user()
            ->student;

        $batchIds = $student
            ->batches
            ->pluck('id');

        return response()->json([

            'batches' =>
                $student->batches,

            'today_schedule' =>
                Schedule::whereIn(
                    'batch_id',
                    $batchIds
                )
                ->where(
                    'day_of_week',
                    strtolower(
                        now()->format('l')
                    )
                )
                ->with([
                    'teacher.user',
                    'room'
                ])
                ->get(),

            'upcoming_exams' =>
                Exam::whereIn(
                    'batch_id',
                    $batchIds
                )
                ->whereDate(
                    'exam_date',
                    '>=',
                    now()
                )
                ->take(5)
                ->get(),

            'upcoming_assignments' =>
                Assignment::whereIn(
                    'batch_id',
                    $batchIds
                )
                ->where(
                    'status',
                    true
                )
                ->take(5)
                ->get(),

            'meetings' =>
                Meeting::whereIn(
                    'batch_id',
                    $batchIds
                )
                ->where(
                    'is_active',
                    true
                )
                ->get(),

            'recent_blogs' =>
                Blog::where(
                    'is_published',
                    true
                )
                ->latest()
                ->take(5)
                ->get(),

            'recent_announcements' =>
                Announcement::latest()
                ->take(5)
                ->get(),

        ]);
    }
}