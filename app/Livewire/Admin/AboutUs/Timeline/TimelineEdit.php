<?php

namespace App\Livewire\Admin\AboutUs\Timeline;

use Livewire\Component;
use App\Models\TimelineCard;
use Illuminate\Support\Facades\Log;

class TimelineEdit extends Component
{
    public $cardId;
    public $card;
    public $year;
    public $description;
    public $description_zh;
    public $debugInfo = '';

    protected function rules()
    {
        return [
            'year' => ['required', 'numeric', 'integer', 'min:1000', 'max:' . (date('Y') + 5)],
            'description' => ['nullable', 'string', 'max:65535'],
            'description_zh' => ['nullable', 'string', 'max:65535'],
        ];
    }

    protected function messages()
    {
        return [
            'year.required' => 'The year field is required.',
            'year.numeric' => 'The year must be a number.',
            'year.min' => 'The year must be at least 1000.',
            'year.max' => 'The year cannot be more than ' . (date('Y') + 5) . '.',
        ];
    }

    public function mount($cardId = null)
    {
        if ($cardId) {
            $this->cardId = $cardId;
            $this->card = TimelineCard::findOrFail($cardId);
            $this->year = $this->card->year;
            $this->description = $this->card->description;
            $this->description_zh = $this->card->description_zh;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules(), $this->messages());
    }

    public function save()
    {
        try {
            $this->validate($this->rules(), $this->messages());

            if ($this->cardId) {
                // Update existing card
                $card = TimelineCard::findOrFail($this->cardId);
                $card->year = $this->year;
                $card->description = $this->description;
                $card->description_zh = $this->description_zh;
                $card->save();
                session()->flash('success', 'Timeline card updated successfully!');
            } else {
                // Create new card
                $maxPosition = TimelineCard::max('position') ?? 0;
                $card = new TimelineCard();
                $card->year = $this->year;
                $card->description = $this->description;
                $card->description_zh = $this->description_zh;
                $card->position = $maxPosition + 1;
                $card->save();
                session()->flash('success', 'Timeline card added successfully!');
            }

            return redirect()->route('admin.timeline');
        } catch (\Exception $e) {
            Log::error('Timeline card save error: ' . $e->getMessage());
            session()->flash('error', 'Error saving timeline card: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.aboutus.timeline.timeline-edit');
    }
}