<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Batch;
use App\Models\Blog;
use App\Models\Campus;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([

            'statistics' => [

                'students' => Student::count(),

                'teachers' => Teacher::count(),

                'campuses' => Campus::count(),

                'batches' => Batch::count(),

            ],

            'recent_announcements' =>
                Announcement::latest()
                    ->take(5)
                    ->get(),

            'recent_blogs' =>
                Blog::where(
                    'is_published',
                    true
                )
                ->latest()
                ->take(5)
                ->get(),

        ]);
    }
}