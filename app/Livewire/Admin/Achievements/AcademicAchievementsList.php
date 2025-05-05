<?php

namespace App\Livewire\Admin\Achievements;

use App\Models\AcademicAchievement;
use Livewire\Component;
use Livewire\WithPagination;

class AcademicAchievementsList extends Component
{
    use WithPagination;

    public $search = '';
    public $examType = '';
    public $year = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteAchievement($id)
    {
        AcademicAchievement::find($id)->delete();
        session()->flash('message', 'Academic achievement deleted successfully.');
    }

    public function render()
    {
        $achievements = AcademicAchievement::query()
            ->when($this->examType, function ($query) {
                return $query->where('exam_type', $this->examType);
            })
            ->when($this->year, function ($query) {
                return $query->where('year', $this->year);
            })
            ->orderBy('year', 'desc')
            ->paginate(10);

        return view('livewire.admin.achievements.academic-achievements-list', [
            'achievements' => $achievements,
        ]);
    }
}