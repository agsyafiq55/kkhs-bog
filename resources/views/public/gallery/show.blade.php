<x-layouts.app>
    <div class="container mx-auto max-w-6xl px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('gallery') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Gallery
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-2/3 bg-gray-100 dark:bg-zinc-700">
                    <img src="{{ asset('storage/' . $image->image) }}" 
                         alt="{{ $image->img_name }}" 
                         class="w-full h-full object-contain">
                </div>
                <div class="md:w-1/3 p-6">
                    <h1 class="text-2xl font-bold mb-2 dark:text-white">{{ $image->img_name }}</h1>
                    
                    <div class="mb-4">
                        <span class="inline-block bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-sm px-3 py-1 rounded-full">
                            {{ $image->category }}
                        </span>
                    </div>
                    
                    @if($image->description)
                        <div class="prose max-w-none mt-4 dark:prose-invert">
                            <p class="text-gray-600 dark:text-gray-300">{{ $image->description }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                        Added on {{ $image->created_at->format('F j, Y') }}
                    </div>
                </div>
            </div>
        </div>

        @if($relatedImages->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-xl font-semibold mb-6 dark:text-white">More from {{ $image->category }}</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($relatedImages as $relatedImage)
                        <a href="{{ route('gallery.show', $relatedImage->id) }}" 
                           class="block group">
                            <div class="aspect-square overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700">
                                <img src="{{ asset('storage/' . $relatedImage->image) }}" 
                                     alt="{{ $relatedImage->img_name }}"
                                     class="w-full h-full object-cover group-hover:opacity-90 transition">
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $relatedImage->img_name }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>