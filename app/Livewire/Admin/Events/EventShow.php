<?php

namespace App\Livewire\Admin\Events;

use Livewire\Component;
use App\Models\Event;

class EventShow extends Component
{
    public $event;

    public function mount($eventId)
    {
        $this->event = Event::findOrFail($eventId);
    }

    public function render()
    {
        return view('livewire.admin.events.event-show', [
            'event' => $this->event,
        ]);
    }
}
