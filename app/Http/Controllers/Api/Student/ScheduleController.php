<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
{
    $student = $request->user()->student;

    return Schedule::with([
        'teacher.user',
        'batch',
        'campus',
        'room'
    ])
    ->whereIn(
        'batch_id',
        $student->batches->pluck('id')
    )
    ->get();
}
}
