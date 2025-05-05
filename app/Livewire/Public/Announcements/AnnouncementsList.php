<?php

namespace App\Livewire\Public\Announcements;

use Livewire\Component;
use App\Models\Announcement;
use Livewire\WithPagination;
use Carbon\Carbon;

class AnnouncementsList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $now = Carbon::now();
        
        // Start with base query
        $query = Announcement::orderBy('published_at', 'desc');
        
        // Filter for active announcements based on date range
        $query->where(function($q) use ($now) {
            // Case 1: No date range set - just check published_at
            $q->where('published_at', '<=', $now)
              ->whereNull('publish_start')
              ->whereNull('publish_end');
              
            // Case 2: Only start date set
            $q->orWhere(function($query) use ($now) {
                $query->whereNotNull('publish_start')
                      ->whereNull('publish_end')
                      ->where('publish_start', '<=', $now);
            });
            
            // Case 3: Only end date set
            $q->orWhere(function($query) use ($now) {
                $query->whereNull('publish_start')
                      ->whereNotNull('publish_end')
                      ->where('publish_end', '>=', $now);
            });
            
            // Case 4: Both dates set
            $q->orWhere(function($query) use ($now) {
                $query->whereNotNull('publish_start')
                      ->whereNotNull('publish_end')
                      ->where('publish_start', '<=', $now)
                      ->where('publish_end', '>=', $now);
            });
        });

        // Apply search filter if provided
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('content', 'like', "%{$this->search}%");
            });
        }

        return view('livewire.public.announcements.announcements-list', [
            'announcements' => $query->paginate(9)
        ]);
    }
}