<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'date' => ['sometimes', 'date'],
            'started_at' => ['sometimes', 'date'],
            'end_at' => ['nullable', 'date', 'after:started_at'],
            'location' => ['sometimes', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'slug' => ['sometimes', 'string', 'max:255'],
            'is_published' => ['boolean'],
            'reservation_opens_at' => ['nullable', 'date'],
            'reservation_closes_at' => ['nullable', 'date'],
            'max_reservations' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
