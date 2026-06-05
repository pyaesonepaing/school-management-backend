<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $batchId = $this->route('batch');

        return [
            'level_id' => 'required|exists:levels,id',
            'campus_id' => 'required|exists:campuses,id',
            'room_id' => 'nullable|exists:rooms,id',
            'batch_name' => 'required|string|max:255',
            'batch_code' => "required|string|max:50|unique:batches,batch_code,$batchId",
            'max_students' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|boolean',
        ];
    }
}