<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampusUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $campusId = $this->route('campus');

        if ($campusId instanceof \App\Models\Campus) {
            $campusId = $campusId->id;
        }

        return [
            'name' => 'required|string|max:255',
            'code' => "required|string|max:50|unique:campuses,code,$campusId",
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:1000',
            'status' => 'nullable|boolean',
        ];
    }
}