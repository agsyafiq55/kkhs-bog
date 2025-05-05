<?php

namespace App\Livewire\Admin\Gallery;

use Livewire\Component;
use App\Models\Gallery;

class GalleryShow extends Component
{
    public $gallery;

    public function mount($galleryId)
    {
        $this->gallery = Gallery::findOrFail($galleryId);
    }

    public function render()
    {
        return view('livewire.admin.gallery.gallery-show', [
            'gallery' => $this->gallery,
        ]);
    }
}