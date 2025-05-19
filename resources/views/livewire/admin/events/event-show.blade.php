@php
// Map event tags to badge colors
$tagColors = [
'Sports' => 'blue',
'Education' => 'emerald',
'Technology' => 'cyan',
'Culture' => 'amber',
'Entertainment' => 'fuchsia',
'Health' => 'green',
'Business' => 'rose',
'Environment' => 'lime',
'Art' => 'purple',
'Science' => 'indigo',
];

// Format the event date
$formattedDate = \Carbon\Carbon::parse($event->event_date)->format('d F Y');
@endphp

<div class="px-4 sm:px-6 md:px-8 lg:px-16 py-6">
    <!-- Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <flux:button href="{{ route('admin.events') }}" class="bg-gray-500 hover:bg-gray-600 transition-colors w-full sm:w-auto">
            <flux:icon name="arrow-left" class="mr-2" />
            {{ __('Back to Events') }}
        </flux:button>

        <flux:button href="{{ route('admin.events.edit', $event->id) }}" class="bg-indigo-600 hover:bg-indigo-700 transition-colors w-full sm:w-auto">
            <flux:icon name="pencil-square" class="mr-2" />
            {{ __('Edit Event') }}
        </flux:button>
    </div>
    <!-- Article Header -->
    <div class="border-neutral-200 bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-sm dark:border-zinc-700 overflow-hidden mb-6">
        <div class="flex flex-col">
            <!-- Hero Image (Top) -->
            <div class="w-full">
                @if($event->thumbnail)
                    <img src="{{ asset('storage/' . $event->thumbnail) }}" 
                        class="w-full h-[200px] sm:h-[250px] md:h-[300px] object-cover"
                        alt="Event Thumbnail" />
                @else
                    <div class="w-full h-[150px] sm:h-[200px] bg-gray-200 dark:bg-zinc-800 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 sm:h-24 w-16 sm:w-24 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M8 12h.01M12 12h.01M16 12h.01M20 12h.01M4 12h.01M8 16h.01M12 16h.01" />
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Article Info (Bottom) -->
            <div class="w-full p-4 sm:p-6">
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                    <flux:badge color="{{ $tagColors[$event->tag] ?? 'zinc' }}" class="inline-flex items-center text-xs sm:text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ $event->tag }}
                    </flux:badge>
                    
                    <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $formattedDate }}
                    </span>
                </div>
                
                <flux:heading size="xl" level="1" class="text-lg sm:text-xl md:text-2xl mb-2">{{ $event->title }}</flux:heading>
                <flux:subheading size="lg" class="text-base sm:text-lg mb-3">{{ __('Event Details') }}</flux:subheading>
                <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300">{{ $event->description }}</p>
            </div>
        </div>
    </div>
    
    <!-- Article Content -->
    <div class="border-neutral-200 bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-sm dark:border-zinc-700 p-4 sm:p-6 mb-6">
        <flux:heading size="lg" class="text-lg sm:text-xl mb-3 sm:mb-4">{{ __('Content') }}</flux:heading>
        <flux:separator variant="subtle" class="mb-3 sm:mb-4" />
        
        <div class="prose prose-sm sm:prose-base prose-indigo dark:prose-invert max-w-none text-justify">
            {!! $event->article !!}
        </div>
    </div>
</div>