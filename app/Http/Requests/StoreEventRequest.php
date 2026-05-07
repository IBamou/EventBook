<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'date' => ['required', 'date'],
            'started_at' => ['required', 'date'],
            'end_at' => ['nullable', 'date', 'after:started_at'],
            'location' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:events,slug'],
            'is_published' => ['boolean'],
            'created_by' => ['required', 'exists:users,id'],
            'reservation_opens_at' => ['nullable', 'date'],
            'reservation_closes_at' => ['nullable', 'date'],
            'max_reservations' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
