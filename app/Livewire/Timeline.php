<?php

// app/Livewire/Public/Timeline.php
namespace App\Livewire;

use Livewire\Component;
use App\Models\TimelineCard;

class Timeline extends Component
{
    public function render()
    {
        $timelineCards = TimelineCard::orderBy('position')->get();
        return view('livewire.timeline', [
            'timelineCards' => $timelineCards
        ]);
    }
}