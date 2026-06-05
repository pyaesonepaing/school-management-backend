<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\Common\FileUploadController;
// admin
use App\Http\Controllers\Api\Admin\CampusController;
use App\Http\Controllers\Api\Admin\RoomController;
use App\Http\Controllers\Api\Admin\LevelController;
use App\Http\Controllers\Api\Admin\BatchController;
use App\Http\Controllers\Api\Admin\TeacherController;
use App\Http\Controllers\Api\Admin\StudentController;
use App\Http\Controllers\Api\Admin\ScheduleController;
use App\Http\Controllers\Api\Admin\MeetingController;
use App\Http\Controllers\Api\Admin\AnnouncementController;
use App\Http\Controllers\Api\Admin\BlogController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;


// teacher
use App\Http\Controllers\Api\Teacher\AssignmentController;
use App\Http\Controllers\Api\Teacher\ExamController;
use App\Http\Controllers\Api\Teacher\MeetingController as TeacherMeetingController;
use App\Http\Controllers\Api\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Api\Teacher\DashboardController as TeacherDashboardController;


// student
use App\Http\Controllers\Api\Student\AssignmentController as StudentAssignmentController;
use App\Http\Controllers\Api\Student\ExamController as StudentExamController;
use App\Http\Controllers\Api\Student\ReportCardController;
use App\Http\Controllers\Api\Student\MeetingController as StudentMeetingController;
use App\Http\Controllers\Api\Student\AnnouncementController as StudentAnnouncementController;
use App\Http\Controllers\Api\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Api\Student\BlogController as StudentBlogController;
use App\Http\Controllers\Api\Student\DashboardController as StudentDashboardController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/logout', [AuthController::class, 'logout']);
    
});


// admin

Route::middleware(['auth:sanctum', 'role:super_admin'])
    ->prefix('admin')
    ->group(function () {

    // dashboard
        Route::get(
            'dashboard',
            [AdminDashboardController::class, 'index']
        );


        Route::apiResource('campuses', CampusController::class);
        Route::apiResource('rooms', RoomController::class);
        Route::apiResource('levels', LevelController::class);
        Route::apiResource('batches', BatchController::class);
        Route::apiResource('teachers', TeacherController::class);
        Route::apiResource('students', StudentController::class);
        Route::apiResource(
            'schedules',
            ScheduleController::class
        );
        Route::apiResource(
            'meetings',
            MeetingController::class
        );
        Route::apiResource(
            'announcements',
            AnnouncementController::class
        );
        Route::apiResource(
            'blogs',
            BlogController::class
        );
    });


// teacher
Route::middleware(['auth:sanctum', 'role:teacher'])
    ->prefix('teacher')
    ->group(function () {
        Route::apiResource('assignments', AssignmentController::class);
        Route::apiResource('exams', ExamController::class);
        Route::post('exam-results/{result}/grade', [ExamController::class,'grade']);
        Route::post(
            'schedules/{schedule}/attendance',
            [TeacherAttendanceController::class, 'mark']
        );
        Route::get(
            'dashboard',
            [TeacherDashboardController::class, 'index']
        );
    });



// student
Route::middleware(['auth:sanctum', 'role:student'])
    ->prefix('student')
    ->group(function () {
        Route::get('assignments', [StudentAssignmentController::class, 'index']);
        Route::post('assignments/{assignment}/submit', [StudentAssignmentController::class, 'submit']);
        Route::get('assignments/{assignment}/submissions', [StudentAssignmentController::class, 'submissions']);
        Route::get('exams', [StudentExamController::class,'index']);
        Route::get('exam-results', [StudentExamController::class,'results']);
        Route::get('report-card', [ReportCardController::class,'show']);
        Route::get(
            'meetings',
            [StudentMeetingController::class, 'index']
        );
        Route::get(
            'announcements',
            [StudentAnnouncementController::class, 'index']
        );
        Route::get(
            'attendance',
            [StudentAttendanceController::class, 'index']
        );
        Route::get(
            'blogs',
            [StudentBlogController::class, 'index']
        );

        Route::get(
            'blogs/{blog}',
            [StudentBlogController::class, 'show']
        );
        Route::get(
            'dashboard',
            [StudentDashboardController::class, 'index']
        );
    });


// common

Route::post(
    '/upload',
    [FileUploadController::class, 'upload']
)->middleware('auth:sanctum');

// temporarily routes
Route::middleware([
    'auth:sanctum',
    'role:super_admin'
])->get('/admin-test', function () {

    return response()->json([
        'message' => 'Admin Access Granted'
    ]);

});


