<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController
{
    // Display a listing of events.
    public function index(Request $request)
    {
        $query = Event::orderBy('is_highlighted', 'desc')
                      ->orderBy('created_at', 'desc');
        
        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply tag filter if provided
        if ($request->has('tag') && !empty($request->tag)) {
            $query->where('tag', $request->tag);
        }
        
        $events = $query->get();
        
        // Get all available tags for the filter dropdown
        $availableTags = Event::select('tag')
            ->distinct()
            ->orderBy('tag')
            ->pluck('tag')
            ->toArray();
            
        return view('public.events.index', compact('events', 'availableTags'));
    }

    // Display the specified event.
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('public.events.show', compact('event'));
    }
}
