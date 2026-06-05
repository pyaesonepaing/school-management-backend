<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
{
    return $request->user()
        ->teacher
        ->schedules()
        ->with([
            'batch',
            'campus',
            'room'
        ])
        ->get();
}

}
