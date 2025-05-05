<?php

namespace App\Livewire\Admin\Announcements;

use Livewire\Component;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AnnouncementsList extends Component
{
    public $announcements = [];
    public $debugInfo = '';
    public $search = ''; 
    public $statusFilter = 'all'; // Default to showing all announcements

    protected $listeners = ['searchUpdated' => 'updateSearch']; 

    public function mount()
    {
        $this->loadAnnouncements();
    }

    public function updateSearch($searchTerm)
    {
        $this->search = $searchTerm;
        $this->loadAnnouncements();
    }

    public function updatedStatusFilter()
    {
        $this->loadAnnouncements();
    }

    public function loadAnnouncements()
    {
        $query = Announcement::query()->orderBy('created_at', 'desc');

        // Apply search filter if search term exists
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter if not set to 'all'
        if ($this->statusFilter === 'active') {
            $query->where(function($q) {
                $q->where(function($subQ) {
                    $subQ->whereNull('publish_start')
                        ->orWhere('publish_start', '<=', now());
                })->where(function($subQ) {
                    $subQ->whereNull('publish_end')
                        ->orWhere('publish_end', '>=', now());
                });
            });
        } elseif ($this->statusFilter === 'inactive') {
            $query->where(function($q) {
                $q->where('publish_start', '>', now())
                    ->orWhere(function($subQ) {
                        $subQ->whereNotNull('publish_end')
                            ->where('publish_end', '<', now());
                    });
            });
        }

        $this->announcements = $query->get();
    }

    // Delete an announcement.
    public function delete($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            
            // Delete the image file from storage if it exists
            if ($announcement->image) {
                $imagePath = str_replace('public/', '', $announcement->image);
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            
            $announcement->delete();
            session()->flash('message', 'Announcement deleted successfully!');
            $this->debugInfo = "Announcement {$id} deleted successfully.";
            $this->loadAnnouncements();
        } catch (\Exception $e) {
            $this->debugInfo = 'Error deleting announcement: ' . $e->getMessage();
            session()->flash('error', 'Error deleting announcement: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.announcements.announcements-list', [
            'announcements' => $this->announcements,
            'debugInfo' => $this->debugInfo,
        ]);
    }

    public function redirectToShow($announcementId)
    {
        return redirect()->route('admin.announcements.show', $announcementId);
    }
    
    public function edit($announcementId)
    {
        return redirect()->route('admin.announcements.edit', $announcementId);
    }
}