<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


#[Fillable(['reserved_by', 'event_id', 'ticket_type_id', 'quantity', 'status', 'total_price', 'cancelled_at'])]
class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    public function reservedBy(): BelongsTo {
        return $this->belongsTo(User::class, 'reserved_by');
    }

    public function event(): BelongsTo {
        return $this->belongsTo(Event::class);
    }
}
