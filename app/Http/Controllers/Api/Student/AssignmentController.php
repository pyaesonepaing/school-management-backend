<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student;

        // Get assignments for batches the student belongs to
        return Assignment::with('teacher', 'batch')
            ->whereIn('batch_id', $student->batches->pluck('id'))
            ->get();
    }

    public function submit(Request $request, Assignment $assignment)
    {
        $student = $request->user()->student;

        $data = $request->validate([
            'file' => 'required|file|max:10240',
            'remark' => 'nullable|string',
        ]);

        $data['file'] = $request->file('file')->store('submissions', 'public');
        $data['student_id'] = $student->id;
        $data['assignment_id'] = $assignment->id;

        $submission = AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => $student->id],
            $data
        );

        return response()->json($submission, 201);
    }

    public function submissions(Request $request, Assignment $assignment)
    {
        // optional: teacher can view submissions
        return $assignment->submissions()->with('student')->get();
    }
}