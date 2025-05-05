<?php

namespace App\Livewire\Admin\Achievements;

use App\Models\CocurricularAchievement;
use App\Models\CocurricularAchievementsItem;
use Livewire\Component;

class CocurricularAchievementForm extends Component
{
    public $cocurricularAchievement;
    public $eventTitle;
    public $category;
    public $eventDate;
    public $description;
    public $isEdit = false;
    
    // New property for achievement items
    public $achievementItems = [];

    protected $rules = [
        'eventTitle' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'eventDate' => 'required|date',
        'description' => 'nullable|string',
        'achievementItems' => 'array',
        'achievementItems.*.achievement' => 'required|string|max:255',
        'achievementItems.*.student_count' => 'required|integer|min:1',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->cocurricularAchievement = CocurricularAchievement::findOrFail($id);
            $this->eventTitle = $this->cocurricularAchievement->event_title;
            $this->category = $this->cocurricularAchievement->category;
            $this->eventDate = $this->cocurricularAchievement->event_date->format('Y-m-d');
            $this->description = $this->cocurricularAchievement->description;
            $this->isEdit = true;
            
            // Load existing achievement items
            $this->achievementItems = $this->cocurricularAchievement->items->map(function($item) {
                return [
                    'id' => $item->id,
                    'achievement' => $item->achievement,
                    'student_count' => $item->student_count,
                ];
            })->toArray();
        } else {
            $this->cocurricularAchievement = new CocurricularAchievement();
            $this->eventDate = now()->format('Y-m-d');
            // Add one empty achievement item by default
            $this->addAchievementItem();
        }
    }

    public function addAchievementItem()
    {
        $this->achievementItems[] = [
            'achievement' => '',
            'student_count' => 1,
        ];
    }

    public function removeAchievementItem($index)
    {
        unset($this->achievementItems[$index]);
        $this->achievementItems = array_values($this->achievementItems);
    }

    public function save()
    {
        $this->validate();

        $this->cocurricularAchievement->event_title = $this->eventTitle;
        $this->cocurricularAchievement->category = $this->category;
        $this->cocurricularAchievement->event_date = $this->eventDate;
        $this->cocurricularAchievement->description = $this->description;
        $this->cocurricularAchievement->save();

        // Handle achievement items
        if ($this->isEdit) {
            // Get existing item IDs
            $existingItemIds = collect($this->achievementItems)
                ->filter(function($item) {
                    return isset($item['id']);
                })
                ->pluck('id')
                ->toArray();
            
            // Delete items that are no longer in the form
            $this->cocurricularAchievement->items()
                ->whereNotIn('id', $existingItemIds)
                ->delete();
        }

        // Save or update achievement items
        foreach ($this->achievementItems as $item) {
            if (isset($item['id'])) {
                // Update existing item
                CocurricularAchievementsItem::find($item['id'])->update([
                    'achievement' => $item['achievement'],
                    'student_count' => $item['student_count'],
                ]);
            } else {
                // Create new item
                $this->cocurricularAchievement->items()->create([
                    'achievement' => $item['achievement'],
                    'student_count' => $item['student_count'],
                ]);
            }
        }

        session()->flash('message', $this->isEdit ? 'Co-curricular achievement updated successfully.' : 'Co-curricular achievement created successfully.');
        return redirect()->route('admin.achievements.cocurricular.index');
    }

    public function render()
    {
        $categories = CocurricularAchievement::distinct()->pluck('category')->toArray();

        return view('livewire.admin.achievements.cocurricular-achievement-form', [
            'categories' => $categories,
        ]);
    }
}