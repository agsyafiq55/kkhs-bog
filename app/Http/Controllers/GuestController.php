<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class GuestController extends Controller
{
    public function index()
    {
        // Fetch events (limit to 4 for display)
        $events = Event::latest()->take(4)->get();
        return view('public.welcome', compact('events'));
    }
}
