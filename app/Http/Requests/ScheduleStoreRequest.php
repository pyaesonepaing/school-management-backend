<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'batch_id' => 'required|exists:batches,id',
            'teacher_id' => 'required|exists:teachers,id',
            'campus_id' => 'required|exists:campuses,id',
            'room_id' => 'nullable|exists:rooms,id',

            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',

            'start_time' => 'required',
            'end_time' => 'required|after:start_time',

            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',

            'status' => 'boolean'
        ];
    }
}