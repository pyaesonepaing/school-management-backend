<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teacherId = $this->route('teacher');

        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$teacherId}",
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:50',
            'teacher_no' => "required|string|unique:teachers,teacher_no,{$teacherId}",
            'qualification' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
            'status' => 'nullable|boolean',
        ];
    }
}