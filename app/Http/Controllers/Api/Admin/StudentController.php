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
        return ApiResponse::success(
            StudentResource::collection(
                Student::with('user','batches')->get()
            )
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

        $student = Student::create([
            'user_id' => $user->id,
            'student_no' => $data['student_no'],
            'gender' => $data['gender'] ?? null,
            'dob' => $data['dob'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        if (!empty($data['batch_ids'])) {
            $student->batches()->sync($data['batch_ids']);
        }

        return response()->json($student->load('user', 'batches'), 201);
    }

    public function show(Student $student)
    {
        return $student->load('user', 'batches');
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

        return $student->load('user', 'batches');
    }

    public function destroy(Student $student)
    {
        $student->user->delete(); // cascades to delete student
        return response()->json(['message' => 'Student deleted']);
    }
}