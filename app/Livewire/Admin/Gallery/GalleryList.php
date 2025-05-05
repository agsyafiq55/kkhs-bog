<?php

namespace App\Livewire\Admin\Gallery;

use Livewire\Component;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryList extends Component
{
    public $galleries = [];
    public $debugInfo = '';
    public $search = ''; // Added search property
    public $selectedCategory = ''; // Added category filter property
    public $availableCategories = []; // To store all available categories

    protected $listeners = ['searchUpdated' => 'updateSearch']; // Listen for SearchBar updates

    public function mount()
    {
        $this->loadAvailableCategories();
        $this->loadGalleries();
    }

    // Load all unique categories from the gallery table
    public function loadAvailableCategories()
    {
        $this->availableCategories = Gallery::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->toArray();
    }

    public function updateSearch($term)
    {
        $this->search = $term;
        $this->loadGalleries();
    }

    public function loadGalleries()
    {
        $query = Gallery::orderBy('created_at', 'desc');

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('img_name', 'like', "%{$this->search}%")
                    ->orWhere('category', 'like', "%{$this->search}%");
            });
        }

        // Apply category filter if selected
        if ($this->selectedCategory !== '') {
            $query->where('category', $this->selectedCategory);
        }

        $this->galleries = $query->get()->map(function ($galleries) {
            $galleries->has_image = !empty($galleries->image);
            return $galleries;
        });
    }

    // Add method to handle category filter changes
    public function updatedSelectedCategory()
    {
        $this->loadGalleries();
    }

    // Delete a gallery item.
    public function delete($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
    
            // Delete the image file from storage if it exists
            if ($gallery->image) {
                $imagePath = str_replace('public/', '', $gallery->image);
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
    
            // Delete the gallery record
            $gallery->delete();
            
            session()->flash('message', 'Gallery image deleted successfully!');
            $this->debugInfo = "Gallery image {$id} deleted successfully.";
            $this->loadGalleries();
        } catch (\Exception $e) {
            $this->debugInfo = 'Error deleting gallery image: ' . $e->getMessage();
            session()->flash('error', 'Error deleting gallery image: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.gallery.gallery-list', [
            'galleries' => $this->galleries,
            'debugInfo' => $this->debugInfo,
        ]);
    }

    public function redirectToShow($galleryId)
    {
        return redirect()->route('admin.gallery.show', $galleryId);
    }
    
    // Handle the edit button click
    public function edit($galleryId)
    {
        return redirect()->route('admin.gallery.edit', $galleryId);
    }
}