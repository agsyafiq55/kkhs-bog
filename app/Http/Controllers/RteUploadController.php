<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class RteUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:5120'], // 5MB
        ]);

        $file = $validated['image'];
        $extension = $file->getClientOriginalExtension();
        $filename = 'rte-images/' . Str::uuid() . '.' . $extension;

        Storage::disk('public')->putFileAs('rte-images', $file, basename($filename));

        return response()->json([
            'url' => asset('storage/' . $filename),
            'path' => $filename,
        ]);
    }
}


