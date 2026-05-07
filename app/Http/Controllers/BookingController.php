<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::where('reserved_by', Auth::id())->get();

        return view('bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();
        $data['reserved_by'] = Auth::id();
        $data['status'] = 'pending';

        Booking::create($data);

        return redirect()->route('bookings.index');
    }
}
