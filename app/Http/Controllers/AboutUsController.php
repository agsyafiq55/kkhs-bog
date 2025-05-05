<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Member;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display the about us page.
     */
    public function index()
    {
        // Get the first (and likely only) about us record
        $aboutUs = AboutUs::first();
        
        // Get all members ordered by position
        $members = Member::orderBy('position')->get();
        
        return view('public.aboutus.index', compact('aboutUs', 'members'));
    }
}