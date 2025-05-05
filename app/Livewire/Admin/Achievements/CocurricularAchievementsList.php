<?php

namespace App\Livewire\Admin\Achievements;

use App\Models\CocurricularAchievement;
use Livewire\Component;
use Livewire\WithPagination;

class CocurricularAchievementsList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $year = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteAchievement($id)
    {
        $achievement = CocurricularAchievement::findOrFail($id);
        
        // Delete all related items first
        $achievement->items()->delete();
        
        // Delete the achievement
        $achievement->delete();

        session()->flash('message', 'Co-curricular achievement deleted successfully.');
    }

    public function render()
    {
        $achievements = CocurricularAchievement::query()
            ->when($this->search, function ($query) {
                return $query->where('event_title', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                return $query->where('category', $this->category);
            })
            ->when($this->year, function ($query) {
                return $query->whereYear('event_date', $this->year);
            })
            ->orderBy('event_date', 'desc')
            ->paginate(10);

        $categories = CocurricularAchievement::distinct()->pluck('category')->toArray();
        $years = CocurricularAchievement::selectRaw('YEAR(event_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return view('livewire.admin.achievements.cocurricular-achievements-list', [
            'achievements' => $achievements,
            'categories' => $categories,
            'years' => $years,
        ]);
    }
}