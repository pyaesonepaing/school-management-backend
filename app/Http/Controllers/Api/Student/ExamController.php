<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student;

        return Exam::with('teacher', 'batch')
            ->whereIn('batch_id', $student->batches->pluck('id'))
            ->get();
    }

    public function results(Request $request)
    {
        $student = $request->user()->student;

        return ExamResult::with('exam.teacher','exam.batch')
            ->where('student_id', $student->id)
            ->get();
    }
}