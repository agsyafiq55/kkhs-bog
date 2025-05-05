<?php

namespace App\Livewire\Public\Gallery;

use Livewire\Component;
use App\Models\Gallery;

class GalleryList extends Component
{
    public $selectedCategory = '';
    
    public function render()
    {
        $query = Gallery::query();
        
        if (!empty($this->selectedCategory)) {
            $query->where('category', $this->selectedCategory);
        }
        
        return view('livewire.public.gallery.gallery-list', [
            'images' => $query->get(),
            'availableCategories' => Gallery::distinct('category')->pluck('category')->filter()
        ]);
    }
}
