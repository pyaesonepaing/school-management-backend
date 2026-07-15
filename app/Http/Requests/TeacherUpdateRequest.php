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
        $teacher = $this->route('teacher');
        $teacherId = $teacher instanceof \App\Models\Teacher ? $teacher->id : $teacher;
        $userId = $teacher instanceof \App\Models\Teacher ? $teacher->user_id : \App\Models\Teacher::findOrFail($teacherId)->user_id;

        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$userId}",
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:50',
            'qualification' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
            'status' => 'nullable|boolean',
        ];
    }
}