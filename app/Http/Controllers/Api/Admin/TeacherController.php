<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherStoreRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        return Teacher::with('user')->get();
    }

    public function store(TeacherStoreRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'teacher',
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'] ?? true,
        ]);

        $lastTeacher = Teacher::latest('id')->first();
        $nextNumber = $lastTeacher ? $lastTeacher->id + 1 : 1;
        $teacherNo = 'HZT-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'teacher_no' => $teacherNo,
            'qualification' => $data['qualification'] ?? null,
            'joining_date' => $data['joining_date'] ?? null,
            'bio' => $data['bio'] ?? null,
        ]);

        return response()->json($teacher->load('user'), 201);
    }

    public function show(Teacher $teacher)
    {
        return $teacher->load('user');
    }

    public function update(TeacherUpdateRequest $request, Teacher $teacher)
    {
        $data = $request->validated();

        $teacher->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? $teacher->user->phone,
            'status' => $data['status'] ?? $teacher->user->status,
            'password' => !empty($data['password']) ? Hash::make($data['password']) : $teacher->user->password,
        ]);

        $teacher->update([
            'qualification' => $data['qualification'] ?? $teacher->qualification,
            'joining_date' => $data['joining_date'] ?? $teacher->joining_date,
            'bio' => $data['bio'] ?? $teacher->bio,
        ]);

        return $teacher->load('user');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete(); // deletes user and cascades
        return response()->json(['message' => 'Teacher deleted']);
    }
}