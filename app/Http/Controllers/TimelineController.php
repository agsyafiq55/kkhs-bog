<?php

// app/Http/Controllers/TimelineController.php
namespace App\Http\Controllers;

use App\Models\TimelineCard;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function reorderCards(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:timeline_cards,id'
        ]);

        foreach ($request->ids as $position => $id) {
            TimelineCard::where('id', $id)->update(['position' => $position]);
        }

        return response()->json(['success' => true]);
    }
}