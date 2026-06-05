<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'batch_id' => 'required|exists:batches,id',

            'platform' => 'required|in:google_meet,zoom,microsoft_teams',

            'title' => 'required|string|max:255',

            'meeting_link' => 'required|url',

            'description' => 'nullable|string',

            'is_active' => 'boolean'
        ];
    }
}