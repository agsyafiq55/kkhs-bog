<div class="py-6">
    <!-- Page Header Section -->
    <div class="mb-6">
        <div class="flex items-center mb-2">
            <flux:icon name="calendar" class="mr-3 h-6 w-6 text-gray-800 dark:text-white"/>
            <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                {{ __('Manage Events') }}</flux:heading>
        </div>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Manage and organize school events.') }}
        </p>
    </div>

    <!-- Controls Section with Background -->
    <div class="mb-6 p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-700">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Search and Filter Controls -->
            <div class="w-full sm:w-2/3 flex flex-col gap-2">
                <!-- Filter Controls -->
                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Search Bar --}}
                    <div class="w-full sm:w-1/2">
                        @livewire('search-bar', [
                        'model' => 'Event',
                        'searchFields' => ['title', 'event_date'],
                        ])
                    </div>

                    <!-- Tag Filter Dropdown -->
                    <div class="w-full sm:w-1/2">
                        <flux:select wire:model.live="selectedTag">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($availableTags as $tag)
                            <option value="{{ $tag }}">{{ $tag }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            </div>

            <!-- Add Button -->
            <div>
                <flux:button href="{{ route('admin.events.create') }}" class="transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __('Create New Event') }}
                </flux:button>
            </div>
        </div>
    </div>

    <flux:separator variant="subtle" class="mb-6" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($events as $event)
        <div class="group relative border-neutral-200 bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border dark:border-zinc-700"
            wire:click="redirectToShow({{ $event->id }})">

            <!-- Event Image -->
            <div class="relative h-48 overflow-hidden">
                @if ($event->thumbnail)
                <img src="{{ asset('storage/' . $event->thumbnail) }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    alt="{{ $event->title }}">
                @else
                <div
                    class="w-full h-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white opacity-75"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M8 12h.01M12 12h.01M16 12h.01M20 12h.01M4 12h.01M8 16h.01M12 16h.01" />
                    </svg>
                </div>
                @endif

                <!-- Date badge -->
                <div
                    class="absolute top-3 right-3 bg-white dark:bg-gray-900 text-gray-800 dark:text-white text-xs font-medium px-2.5 py-1 rounded-full shadow">
                    {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                </div>

                @if($event->is_highlighted)
                <div class="absolute top-3 left-3 bg-amber-500 text-white text-xs font-medium px-2.5 py-1 rounded-full shadow flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                    </svg>
                    Featured
                </div>
                @endif
            </div>

            <!-- Event Content -->
            <div class="p-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 line-clamp-1">
                    {{ $event->title }}
                </h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-2 mt-4">
                    <flux:button wire:click.stop="edit({{ $event->id }})"
                        class="text-sm bg-transparent hover:bg-blue-50 dark:hover:bg-blue-900 text-blue-600 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline-block"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit
                    </flux:button>

                    <flux:button
                        x-on:click="event.stopPropagation(); $flux.modal('delete-event-{{ $event->id }}').show()"
                        class="text-sm bg-transparent hover:bg-red-50 dark:hover:bg-red-900 text-red-600 dark:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline-block"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Delete
                    </flux:button>
                </div>
            </div>

            <!-- Hover overlay for better UX -->
            <div
                class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity pointer-events-none">
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty state -->
    @if (count($events) === 0)
    <div class="text-center py-12 bg-gray-50 dark:bg-zinc-700 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">No events found</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first event.</p>
    </div>
    @endif

    <!-- Delete confirmation modals -->
    @foreach ($events as $event)
    <flux:modal name="delete-event-{{ $event->id }}" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete event?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete "{{ $event->title }}".</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button
                    wire:click="delete({{ $event->id }})"
                    x-on:click="$flux.modal('delete-event-{{ $event->id }}').close()"
                    variant="danger">
                    Delete event
                </flux:button>
            </div>
        </div>
    </flux:modal>
    @endforeach
</div>