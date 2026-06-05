<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        return Exam::with('batch', 'results')
            ->where('teacher_id', $teacher->id)
            ->get();
    }

    public function store(Request $request)
    {
        $teacher = $request->user()->teacher;

        $data = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exam_date' => 'nullable|date',
            'total_marks' => 'nullable|numeric|min:0',
            'status' => 'nullable|boolean',
        ]);

        $data['teacher_id'] = $teacher->id;

        $exam = Exam::create($data);

        return response()->json($exam, 201);
    }

    public function show(Exam $exam)
    {
        return $exam->load('batch', 'results.student');
    }

    public function update(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'batch_id' => 'sometimes|exists:batches,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'exam_date' => 'nullable|date',
            'total_marks' => 'nullable|numeric|min:0',
            'status' => 'nullable|boolean',
        ]);

        $exam->update($data);

        return response()->json($exam);
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return response()->json(['message'=>'Exam deleted']);
    }

    // Teacher grading student
    public function grade(Request $request, ExamResult $result)
    {
        $data = $request->validate([
            'marks_obtained' => 'required|numeric|min:0',
            'remark' => 'nullable|string',
        ]);

        $result->update([
            'marks_obtained' => $data['marks_obtained'],
            'is_graded' => true,
            'remark' => $data['remark'] ?? null
        ]);

        return response()->json($result);
    }
}