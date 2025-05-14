<div>
    <!-- Page Hero Section -->
    <div class="bg-black relative overflow-hidden p-0 m-0 shadow-md -mx-6 -mt-6 lg:-mx-8 lg:-mt-8">
        <!-- Background image with overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://lansugarden.org/content/CI_assets/PDXLeesIlluminatedLion-MAMM22.jpg?v=1692838685344"
                alt="Events background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-zinc-700/50 dark:bg-black/50"></div>
        </div>
        <div class="relative z-10 flex flex-col items-center text-center py-16 px-4">
            
            <!-- Main heading -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-2">Events</h1>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-red-800 mb-6">活动</h2>
            
            <!-- Subtitle -->
            <p class="text-gray-300 max-w-2xl mb-2">
                Stay up-to-date with the latest events and activities. <br> 及时了解最新的事件和活动。
            </p>
            
            <!-- Search and filter section -->
            <div class="w-full max-w-3xl flex flex-col sm:flex-row gap-2 mt-4">
                {{-- Search Bar --}}
                <div class="flex-grow relative">
                    <flux:input icon="magnifying-glass" wire:model.live="search" placeholder="Search for Events..."/>
                </div>
                
                {{-- Dropdown Filter --}}
                <div class="sm:w-1/3">
                    <flux:select wire:model.live="selectedTag">
                        <option value="">Filter by Tag</option>
                        @foreach ($availableTags as $tag)
                            <option value="{{ $tag }}">{{ $tag }}</option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-6xl">
        <!-- Events Grid -->
        <div class="mt-8">
            <!-- Loading Skeleton -->
            <div wire:loading.flex wire:target="search, selectedTag"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 mx-auto max-w-6xl">
                @for ($i = 0; $i < 3; $i++)
                    <div
                        class="relative overflow-hidden rounded-lg shadow-md border border-gray-100 dark:border-zinc-800 h-96 bg-white dark:bg-zinc-900 animate-pulse w-full">
                        <div class="h-48 bg-gray-200 dark:bg-zinc-900/50 w-full"></div>
                        <div class="p-5 space-y-4">
                            <div class="h-6 bg-gray-200 dark:bg-zinc-800 rounded w-3/4"></div>
                            <div class="space-y-2">
                                <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded"></div>
                                <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded w-5/6"></div>
                            </div>
                            <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded w-1/4 mt-4"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Results Grid -->
            <div wire:loading.remove wire:target="search, selectedTag"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @foreach ($events as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="block hover:no-underline group">
                        <article class="flex flex-col relative">
                            <!-- Square Image Container -->
                            <div class="aspect-square w-full overflow-hidden rounded-lg">
                                <img alt="{{ $event->title }}"
                                    src="{{ $event->thumbnail ? asset('storage/' . $event->thumbnail) : asset('images/placeholder.jpg') }}"
                                    class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105" />
                            </div>

                            <!-- Content Section - No Background -->
                            <div>
                                <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white line-clamp-2 group-hover:text-red-500 transition-colors">
                                    {{ $event->title }}
                                </h3>

                                <div class="mt-1 flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                    <flux:badge color="{{ $tagColors[$event->tag] ?? 'zinc' }}"
                                        class="inline-block text-xs font-medium">
                                        {{ $event->tag }}
                                    </flux:badge>
                                    
                                    <div class="flex items-center">
                                        <span>{{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('M d, Y') : 'Upcoming' }}</span>
                                    </div>
                                </div>
                            </div>

                            @if ($event->is_highlighted)
                                <div class="absolute top-3 left-3 bg-amber-500 text-white text-xs font-medium px-2.5 py-1 rounded-full shadow flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    Featured
                                </div>
                            @endif
                        </article>
                    </a>
                @endforeach
            </div>

            <!-- Empty State remains unchanged -->
            @if ($events->isEmpty())
                <div class="text-center mt-8 p-8 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">No events found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        @if ($search || $selectedTag)
                            Try adjusting your search or filter criteria.
                        @else
                            There are no events available at the moment.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
