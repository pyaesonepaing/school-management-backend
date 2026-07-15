<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student');
        $studentId = $student instanceof \App\Models\Student ? $student->id : $student;
        $userId = $student instanceof \App\Models\Student ? $student->user_id : \App\Models\Student::findOrFail($studentId)->user_id;

        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$userId}",
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:50',
            'student_no' => "required|string|unique:students,student_no,{$studentId}",
            'gender' => 'nullable|in:male,female',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:1000',
            'status' => 'nullable|boolean',
            'batch_ids' => 'nullable|array',
            'batch_ids.*' => 'exists:batches,id',
        ];
    }
}