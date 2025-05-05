<?php

namespace App\Livewire\Public\Events;

use Livewire\Component;
use App\Models\Event;

class EventsList extends Component
{
    public $search = '';
    public $selectedTag = '';
    public $tagColors = [
        'Sports' => 'blue',
        'Education' => 'emerald',
        'Technology' => 'cyan',
        'Culture' => 'amber',
        'Entertainment' => 'fuchsia',
        'Health' => 'green',
        'Business' => 'rose',
        'Environment' => 'lime',
        'Art' => 'purple',
        'Science' => 'indigo',
    ];

    public function render()
    {
        $query = Event::orderBy('is_highlighted', 'desc')
            ->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if (!empty($this->selectedTag)) {
            $query->where('tag', $this->selectedTag);
        }

        return view('livewire.public.events.events-list', [
            'events' => $query->get(),
            'availableTags' => Event::distinct('tag')->pluck('tag')
        ]);
    }
}