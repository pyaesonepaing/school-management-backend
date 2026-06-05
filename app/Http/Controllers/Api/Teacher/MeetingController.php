<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
{
    $teacher = $request->user()->teacher;

    $batchIds = $teacher
        ->schedules()
        ->pluck('batch_id')
        ->unique();

    return Meeting::whereIn(
        'batch_id',
        $batchIds
    )->get();
}
}
