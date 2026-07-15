<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        return response()->json(
            Student::with(
                'user',
                'batches.level',
                'batches.campus'
            )->get()
        );
    }

    public function store(StudentStoreRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'student',
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'] ?? true,
        ]);

        $lastStudent = Student::latest('id')->first();

        $nextNumber = $lastStudent
            ? $lastStudent->id + 1
            : 1;

        $studentNo =
            'HZA-' .
            str_pad(
                $nextNumber,
                6,
                '0',
                STR_PAD_LEFT
            );

        $student = Student::create([
            'user_id' => $user->id,
            'student_no' => $studentNo,
            'gender' => $data['gender'] ?? null,
            'dob' => $data['dob'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        if (!empty($data['batch_ids'])) {
            $student->batches()->sync($data['batch_ids']);
        }

        return response()->json($student->load('user', 'batches.level', 'batches.campus'), 201);
    }

    public function show(Student $student)
    {
        return $student->load('user', 'batches.level', 'batches.campus');
    }

    public function update(StudentUpdateRequest $request, Student $student)
    {
        $data = $request->validated();

        $student->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? $student->user->phone,
            'status' => $data['status'] ?? $student->user->status,
            'password' => !empty($data['password']) ? Hash::make($data['password']) : $student->user->password,
        ]);

        $student->update([
            'student_no' => $data['student_no'],
            'gender' => $data['gender'] ?? $student->gender,
            'dob' => $data['dob'] ?? $student->dob,
            'address' => $data['address'] ?? $student->address,
        ]);

        if (!empty($data['batch_ids'])) {
            $student->batches()->sync($data['batch_ids']);
        }

        return $student->load('user', 'batches.level', 'batches.campus');
    }

    public function destroy(Student $student)
    {
        $student->user->delete(); // cascades to delete student
        return response()->json(['message' => 'Student deleted']);
    }

    public function bulkDelete(Request $request)
{
    $request->validate([
        'student_ids' => 'required|array',
        'student_ids.*' => 'exists:students,id',
    ]);

    $students = Student::whereIn(
        'id',
        $request->student_ids
    )->get();

    foreach ($students as $student) {
        $student->user->delete();
    }

    return response()->json([
        'message' => 'Students deleted successfully'
    ]);
}

    public function resetPassword(Student $student)
    {
        $student->user->update([
            'password' => Hash::make('Student123!@#')
        ]);
        return response()->json(['message' => 'Password reset to Student123!@#']);
    }
}