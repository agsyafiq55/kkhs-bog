@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center mb-2">
                <flux:icon name="clock" class="mr-3 h-6 w-6 text-gray-800 dark:text-white" />
                <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                    {{ __('Timeline Manager') }}
                </flux:heading>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Manage your timeline cards and their order.') }}</p>
        </div>

        <flux:button href="{{ route('admin.timeline.create') }}" class="bg-indigo-600 hover:bg-indigo-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            {{ __('Add a Card') }}
        </flux:button>
    </div>

    <!-- Timeline Cards List -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
        <flux:heading size="lg" class="mb-4">Timeline Cards</flux:heading>

        <div x-data="{
            init() {
                new Sortable(this.$refs.cardsList, {
                    animation: 150,
                    ghostClass: 'opacity-50',
                    onSort: (evt) => {
                        const orderedIds = Array.from(evt.to.children)
                            .map(item => item.getAttribute('data-id'));
                        @this.call('updateOrder', orderedIds);
                    }
                });
            }
        }">
            <ul x-ref="cardsList" class="space-y-4">
                @foreach ($cards as $card)
                <li class="bg-gray-50 dark:bg-zinc-800 p-5 rounded-lg shadow-sm border border-gray-100 dark:border-zinc-700 flex justify-between items-center"
                    data-id="{{ $card->id }}">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <span class="font-bold text-lg text-gray-800 dark:text-white">{{ $card->year }}</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $card->description }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $card->description_zh }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.timeline.edit', $card->id) }}"
                            class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <button wire:click="deleteCard({{ $card->id }})"
                            class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                        <div class="p-2 text-gray-500 dark:text-gray-400 cursor-move">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                            </svg>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>

            @if (count($cards) === 0)
            <div class="text-center p-8 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-100 dark:border-zinc-700">
                <p class="text-gray-500 dark:text-gray-400">No timeline cards available yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>