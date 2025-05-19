<div class="h-screen flex flex-col">
    <!-- Main content -->
    <div class="flex flex-col md:flex-row flex-1 overflow-hidden rounded-xl">
        <!-- Image section (takes most of the screen) -->
        <div class="md:w-3/4 bg-black flex items-center justify-center h-full overflow-hidden relative">
            <!-- Back button (X) -->
            <a href="{{ route('admin.gallery') }}" 
               class="absolute top-4 left-4 z-20 bg-black bg-opacity-50 hover:bg-opacity-70 text-white rounded-full p-2.5 transition-all duration-200 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            
            <img src="{{ asset('storage/' . $gallery->image) }}" 
                 alt="{{ $gallery->img_name }}" 
                 class="max-h-full max-w-full object-contain">
        </div>
        
        <!-- Info sidebar -->
        <div class="md:w-1/4 bg-white dark:bg-zinc-900 p-4 md:p-6 overflow-y-auto">
            <flux:heading size="xl" class="mb-2">{{ $gallery->img_name }}</flux:heading>
            
            <div class="mb-4">
                <flux:badge color="blue" class="inline-flex items-center">
                    <flux:icon name="photo" class="mr-1 h-4 w-4" />
                    {{ $gallery->category }}
                </flux:badge>
            </div>
            
            @if($gallery->description)
                <div class="mt-4">
                    <flux:text variant="strong" class="text-gray-700 dark:text-gray-300 mb-1">Description:</flux:text>
                    <p class="text-gray-600 dark:text-gray-300 text-justify">{{ $gallery->description }}</p>
                </div>
            @endif
            
            <div class="mt-6 text-sm text-gray-500 dark:text-gray-400">
                Added on {{ $gallery->created_at->format('F j, Y') }}
            </div>
        </div>
    </div>
</div>