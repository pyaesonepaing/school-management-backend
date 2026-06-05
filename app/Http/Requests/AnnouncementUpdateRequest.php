<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'title' => 'required|string|max:255',

            'message' => 'required|string',

            'publish_at' => 'nullable|date',

            'expire_at' => 'nullable|date|after:publish_at',

            'is_published' => 'boolean',

            'targets' => 'required|array|min:1',

            'targets.*.target_type' => 'required|in:all,student,batch,campus',

            'targets.*.target_id' => 'nullable|integer',

        ];
    }
}