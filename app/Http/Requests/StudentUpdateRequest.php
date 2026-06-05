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
        $studentId = $this->route('student');

        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$studentId}",
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