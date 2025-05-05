<div>
    <div class="mb-6">
        <a href="{{ route('admin.gallery.index') }}" class="text-blue-600 hover:underline flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Gallery List
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:w-2/3">
                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->img_name }}" class="w-full h-auto">\

            </div>
            <div class="md:w-1/3 p-6">
                <h1 class="text-2xl font-bold mb-2">{{ $gallery->img_name }}</h1>
                
                <div class="mb-4">
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                        {{ $gallery->category }}
                    </span>
                </div>
                
                <div class="prose max-w-none mt-4">
                    <p>{{ $gallery->description }}</p>
                </div>
                
                <div class="mt-6 text-sm text-gray-500">
                    Added on {{ $gallery->created_at->format('F j, Y') }}
                </div>
                
                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Edit
                    </a>
                    <button onclick="if(confirm('Are you sure you want to delete this image?')) { window.location.href='{{ route('admin.gallery') }}'; }" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>