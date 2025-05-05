<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the announcements.
     */
    public function index()
    {
        $announcements = Announcement::orderBy('published_at', 'desc')->paginate(10);
        return view('public.announcements.index', compact('announcements'));
    }

    /**
     * Display the specified announcement.
     */
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('public.announcements.show', compact('announcement'));
    }
}