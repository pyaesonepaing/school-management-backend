<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        return Assignment::with('batch')
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
            'attachment' => 'nullable|file|max:10240', // 10MB
            'deadline' => 'nullable|date',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('assignments', 'public');
        }

        $data['teacher_id'] = $teacher->id;

        $assignment = Assignment::create($data);

        return response()->json($assignment, 201);
    }

    public function show(Assignment $assignment)
    {
        return $assignment->load('batch', 'submissions');
    }

    public function update(Request $request, Assignment $assignment)
    {
        $data = $request->validate([
            'batch_id' => 'sometimes|exists:batches,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240',
            'deadline' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('attachment')) {
            // delete old file
            if ($assignment->attachment) {
                Storage::disk('public')->delete($assignment->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('assignments', 'public');
        }

        $assignment->update($data);

        return response()->json($assignment);
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->attachment) {
            Storage::disk('public')->delete($assignment->attachment);
        }
        $assignment->delete();

        return response()->json(['message' => 'Assignment deleted']);
    }
}