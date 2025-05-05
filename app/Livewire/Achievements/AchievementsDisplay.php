<?php

namespace App\Livewire\Achievements;

use App\Models\AcademicAchievement;
use App\Models\CocurricularAchievement;
use Livewire\Component;

class AchievementsDisplay extends Component
{
    public $activeTab = 'academic';
    public $selectedYear = null;
    public $selectedCategory = null;
    
    public function mount()
    {
        // Set default year to the most recent year with data
        $latestAcademicYear = AcademicAchievement::orderBy('year', 'desc')->value('year');
        $latestCocurricularYear = CocurricularAchievement::selectRaw('YEAR(event_date) as year')
            ->orderBy('year', 'desc')
            ->value('year');
            
        $this->selectedYear = $latestAcademicYear ?? $latestCocurricularYear ?? date('Y');
    }
    
    public function setTab($tab)
    {
        $this->activeTab = $tab;
        
        // Reset filters when changing tabs
        if ($tab === 'academic') {
            $this->selectedCategory = null;
            $latestYear = AcademicAchievement::orderBy('year', 'desc')->value('year');
            $this->selectedYear = $latestYear ?? date('Y');
        } else {
            $latestYear = CocurricularAchievement::selectRaw('YEAR(event_date) as year')
                ->orderBy('year', 'desc')
                ->value('year');
            $this->selectedYear = $latestYear ?? date('Y');
        }
    }
    
    public function setYear($year)
    {
        $this->selectedYear = $year;
    }
    
    public function setCategory($category)
    {
        $this->selectedCategory = $category === $this->selectedCategory ? null : $category;
    }
    
    public function render()
    {
        $academicYears = AcademicAchievement::distinct()->orderBy('year', 'desc')->pluck('year');
        
        $cocurricularYears = CocurricularAchievement::selectRaw('YEAR(event_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            
        $categories = CocurricularAchievement::distinct()->orderBy('category')->pluck('category');
        
        $academicAchievements = AcademicAchievement::with('grades')
            ->when($this->selectedYear, function ($query) {
                return $query->where('year', $this->selectedYear);
            })
            ->orderBy('exam_type')
            ->get();
            
        $cocurricularAchievements = CocurricularAchievement::query()
            ->when($this->selectedYear, function ($query) {
                return $query->whereYear('event_date', $this->selectedYear);
            })
            ->when($this->selectedCategory, function ($query) {
                return $query->where('category', $this->selectedCategory);
            })
            ->orderBy('event_date', 'desc')
            ->get();
            
        return view('livewire.achievements.achievements-display', [
            'academicYears' => $academicYears,
            'cocurricularYears' => $cocurricularYears,
            'categories' => $categories,
            'academicAchievements' => $academicAchievements,
            'cocurricularAchievements' => $cocurricularAchievements,
        ]);
    }
}