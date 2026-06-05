<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class ReportCardController extends Controller
{
    public function show(Request $request)
    {
        $student = $request->user()->student;

        $batches = $student->batches()->with(['level','campus'])->get();

        $report = [];

        foreach($batches as $batch){
            $exams = $batch->exams()->with(['results' => function($q) use ($student){
                $q->where('student_id',$student->id);
            }])->get();

            $assignments = $batch->assignments()->with(['submissions' => function($q) use ($student){
                $q->where('student_id',$student->id);
            }])->get();

            $report[] = [
                'batch' => $batch->batch_name,
                'level' => $batch->level->name,
                'campus' => $batch->campus->name,
                'exams' => $exams,
                'assignments' => $assignments
            ];
        }

        return response()->json([
            'student' => $student->user->name,
            'report_card' => $report
        ]);
    }
}