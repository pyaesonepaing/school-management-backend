<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:50',
            'teacher_no' => 'required|string|unique:teachers,teacher_no',
            'qualification' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
            'status' => 'nullable|boolean',
        ];
    }
}