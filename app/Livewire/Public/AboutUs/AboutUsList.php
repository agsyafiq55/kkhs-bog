<?php

namespace App\Livewire\Public\AboutUs;

use Livewire\Component;
use App\Models\AboutUs;
use App\Models\Member;

class AboutUsList extends Component
{
    public $aboutUs;
    public $members;
    public $chairman;
    public $selectedYear = null;
    public $availableYears = [];

    public function mount()
    {
        // Get all available years from both AboutUs and Member models
        $aboutUsYears = AboutUs::distinct()->pluck('year')->toArray();
        $memberYears = Member::distinct()->pluck('year')->toArray();
        
        // Merge and remove duplicates
        $this->availableYears = array_unique(array_merge($aboutUsYears, $memberYears));
        
        // Sort years in descending order (newest first)
        rsort($this->availableYears);
        
        // Set default year to the most recent one
        $this->selectedYear = $this->availableYears[0] ?? null;
        
        // Load data for the selected year
        $this->loadDataForYear();
    }
    
    public function updatedSelectedYear()
    {
        // This method is automatically called when selectedYear changes
        $this->loadDataForYear();
    }
    
    protected function loadDataForYear()
    {
        if ($this->selectedYear) {
            // Get about us information for the selected year
            $this->aboutUs = AboutUs::where('year', $this->selectedYear)->latest()->first();
            
            // Get members for the selected year
            $this->members = Member::where('year', $this->selectedYear)->get();
            $this->chairman = $this->members->firstWhere('position', 'Chairman');
        } else {
            // If no year is selected, get the latest data
            $this->aboutUs = AboutUs::latest()->first();
            $this->members = Member::all();
            $this->chairman = $this->members->firstWhere('position', 'Chairman');
        }
    }

    public function render()
    {
        return view('livewire.public.about-us.about-us-list');
    }
}