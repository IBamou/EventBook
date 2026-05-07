<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('started_at', '>', now())->get();

        return view('events.index', compact('events'));
    }

    /**
     * Display a listing of the resource.
     */
    public function archives()
    {
        $this->authorize('viewArchived', Event::class);

        $events = Event::onlyTrashed()
            ->where('created_by', Auth::id())
            ->get();

        return view('events.archives', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Event::class);

        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $this->authorize('create', Event::class);

        $data = $request->validated();

        Event::create([
            ...$data,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $data = $request->validated();

        $event->update($data);

        return redirect()->route('events.index');
    }

    /**
     * Archive the specified resource from storage.
     */
    public function archive(Event $event)
    {
        $this->authorize('archive', $event);

        $event->delete();

        return redirect()->route('events.index');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Event $event)
    {
        $this->authorize('restore', $event);

        $event->restore();

        return redirect()->route('events.index');
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete(Event $event)
    {
        $this->authorize('forceDelete', $event);

        $event->forceDelete();

        return redirect()->route('events.index');
    }
}
