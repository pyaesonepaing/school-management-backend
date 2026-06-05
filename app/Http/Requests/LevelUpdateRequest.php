<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LevelUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $levelId = $this->route('level');

        return [
            'name' => "required|string|max:255|unique:levels,name,$levelId",
            'description' => 'nullable|string|max:1000',
            'status' => 'nullable|boolean',
        ];
    }
}