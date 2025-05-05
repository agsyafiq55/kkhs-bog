<?php

namespace App\Livewire\Admin\AboutUs\Members;

use Livewire\Component;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;

class MemberList extends Component
{
    public $memberId;
    public $members;
    public $debugInfo = '';
    public $search = ''; // Added search property
    public $selectedYear = ''; // Added year filter property
    public $availableYears = []; // To store all available years

    protected $listeners = ['searchUpdated' => 'updateSearch']; // Listen for SearchBar updates

    public function mount()
    {
        $this->loadAvailableYears();
        $this->loadMembers();
    }
    
    // Load all unique years from the members table
    public function loadAvailableYears()
    {
        $this->availableYears = Member::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
    }
    
    public function loadMembers()
    {
        $query = Member::orderByRaw("
            CASE position
                WHEN 'Chairman' THEN 1
                WHEN 'Vice Chairman I' THEN 2
                WHEN 'Vice Chairman II' THEN 3
                WHEN 'Secretary' THEN 4
                WHEN 'Treasurer' THEN 5
                WHEN 'Supervision' THEN 6
                WHEN 'Member of Board of Governor' THEN 7
                ELSE 8
            END
        ");
        
        // Apply year filter if selected
        if ($this->selectedYear !== '') {
            $query->where('year', $this->selectedYear);
        }

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('member_name', 'like', "%{$this->search}%")
                    ->orWhere('position', 'like', "%{$this->search}%");
            });
        }
        
        $this->members = $query->get();
    }
    
    // Add method to handle year filter changes
    public function updatedSelectedYear()
    {
        $this->loadMembers();
    }
    
    // Add the updateSearch method to handle search events
    public function updateSearch($term)
    {
        $this->search = $term;
        $this->loadMembers();
    }

    public function render()
    {
        return view('livewire.admin.aboutus.members.members-list', [
            'members' => $this->members,
            'debugInfo' => $this->debugInfo,
        ]);
    }

    public function deleteMember($memberId)
    {
        try {
            $member = Member::findOrFail($memberId);
            
            // Delete the member's photo if it exists
            if ($member->photo) {
                $imagePath = str_replace('public/', '', $member->photo);
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            
            $result = $member->delete();
            
            if ($result) {
                $this->loadMembers();
                session()->flash('message', 'Member deleted successfully!');
                $this->debugInfo = "Member {$memberId} deleted successfully.";
            } else {
                throw new \Exception('Failed to delete member');
            }
        } catch (\Exception $e) {
            $this->debugInfo = 'Error deleting member: ' . $e->getMessage();
            session()->flash('error', 'Error deleting member: ' . $e->getMessage());
        }
    }
}