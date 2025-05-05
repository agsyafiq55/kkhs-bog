<?php

namespace App\Livewire\Admin\AboutUs\Timeline;

use Livewire\Component;
use App\Models\TimelineCard;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TimelineList extends Component
{
    public $cards;

    protected $listeners = ['updateOrder'];

    public function mount()
    {
        $this->loadCards();
        Log::info('TimelineManager mounted');
    }

    public function updateOrder(array $orderedIds)
    {
        Log::info('updateOrder method called', ['orderedIds' => $orderedIds]);

        DB::beginTransaction();
        try {
            foreach ($orderedIds as $index => $id) {
                $card = TimelineCard::find($id);
                if ($card) {
                    if ($card->position != ($index + 1)) {
                        $card->position = $index + 1;
                        $card->save();
                        Log::info('Updated card position', ['id' => $id, 'position' => $index + 1]);
                    }
                } else {
                    Log::warning('Card not found during reorder', ['id' => $id]);
                }
            }
            DB::commit();
            session()->flash('message', 'Timeline order updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating timeline order: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'An error occurred while updating the timeline order: ' . $e->getMessage());
        } finally {
            $this->loadCards();
        }
    }

    private function reorderCards()
    {
        Log::info('Reordering cards after deletion');
        $cards = TimelineCard::orderBy('position', 'asc')->get();

        DB::beginTransaction();
        try {
            foreach ($cards as $index => $card) {
                $newPosition = $index + 1;
                if ($card->position != $newPosition) {
                    $card->position = $newPosition;
                    $card->save();
                    Log::info('Reordered card', ['id' => $card->id, 'new_position' => $newPosition]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error reordering cards: ' . $e->getMessage());
        }
    }

    private function loadCards()
    {
        $this->cards = TimelineCard::orderBy('position', 'asc')->get();
        Log::info('Cards loaded', ['count' => $this->cards->count()]);
    }

    public function render()
    {
        return view('livewire.admin.aboutus.timeline.timeline-list');
    }
}