<?php

namespace App\Livewire\Admin\Achievements;

use App\Models\AcademicAchievement;
use App\Models\AcademicAchievementGrade;
use Livewire\Component;

class AcademicAchievementForm extends Component
{
    public $academicAchievement;
    public $examType;
    public $year;
    public $gps;
    public $certificatePercentage;
    public $grades = [];
    public $isEdit = false;

    protected $rules = [
        'examType' => 'required|in:SPM,STPM',
        'year' => 'required|integer|min:1990|max:2100',
        'gps' => 'required|numeric|min:0|max:5',
        'certificatePercentage' => 'required|numeric|min:0|max:100',
        'grades' => 'required|array|min:1',
        'grades.*.grade' => 'required|string|max:10',
        'grades.*.student_count' => 'required|integer|min:0',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->academicAchievement = AcademicAchievement::with('grades')->findOrFail($id);
            $this->examType = $this->academicAchievement->exam_type;
            $this->year = $this->academicAchievement->year;
            $this->gps = $this->academicAchievement->gps;
            $this->certificatePercentage = $this->academicAchievement->certificate_percentage;
            $this->grades = $this->academicAchievement->grades->toArray();
            $this->isEdit = true;
        } else {
            $this->academicAchievement = new AcademicAchievement();
            $this->addGrade();
        }
    }

    public function addGrade()
    {
        $this->grades[] = [
            'grade' => '',
            'student_count' => 0,
        ];
    }

    public function removeGrade($index)
    {
        unset($this->grades[$index]);
        $this->grades = array_values($this->grades);
    }

    public function save()
    {
        $this->validate();

        $this->academicAchievement->exam_type = $this->examType;
        $this->academicAchievement->year = $this->year;
        $this->academicAchievement->gps = $this->gps;
        $this->academicAchievement->certificate_percentage = $this->certificatePercentage;
        $this->academicAchievement->save();

        // Delete existing grades if editing
        if ($this->isEdit) {
            $this->academicAchievement->grades()->delete();
        }

        // Create new grades
        foreach ($this->grades as $grade) {
            $this->academicAchievement->grades()->create([
                'grade' => $grade['grade'],
                'student_count' => $grade['student_count'],
            ]);
        }

        session()->flash('message', $this->isEdit ? 'Academic achievement updated successfully.' : 'Academic achievement created successfully.');
        return redirect()->route('admin.achievements.academic.index');
    }

    public function render()
    {
        return view('livewire.admin.achievements.academic-achievement-form');
    }
}