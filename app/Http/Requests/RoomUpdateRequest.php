<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roomId = $this->route('room');

        return [
            'name' => 'required|string|max:255',
            'campus_id' => 'required|exists:campuses,id',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'nullable|boolean',
        ];
    }
}