<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery images.
     */
    public function index($category = null)
    {
        return view('public.gallery.index', [
            'selectedCategory' => $category
        ]);
    }

    /**
     * Display the specified gallery image.
     */
    public function show($id)
    {
        $image = Gallery::findOrFail($id);
        
        // Get related images from the same category (excluding the current image)
        $relatedImages = Gallery::where('category', $image->category)
            ->where('id', '!=', $image->id)
            ->limit(4)
            ->get();
            
        return view('public.gallery.show', compact('image', 'relatedImages'));
    }
}