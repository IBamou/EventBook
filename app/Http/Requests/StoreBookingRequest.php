<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'event_id' => ['required', 'exists:events,id'],
            'ticket_type_id' => ['required', 'exists:ticket_types,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'status' => ['sometimes', 'in:pending,paid,cancelled'],
        ];
    }
}
