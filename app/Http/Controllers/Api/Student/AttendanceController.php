<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    

    public function index(Request $request)
{
    return $request
        ->user()
        ->student
        ->attendances()
        ->with('schedule.batch')
        ->latest()
        ->get();
}
}
