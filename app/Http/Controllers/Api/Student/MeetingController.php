<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(
        Request $request
    ) {
        $student = $request
            ->user()
            ->student;

        return Meeting::with([
            'batch',
        ])
        ->whereIn(
            'batch_id',
            $student->batches->pluck('id')
        )
        ->where('is_active', true)
        ->get();
    }
}