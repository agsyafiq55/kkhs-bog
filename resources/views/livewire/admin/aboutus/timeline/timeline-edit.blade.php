<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center mb-2">
                <flux:icon name="clock" class="mr-3 text-indigo-600 dark:text-indigo-400" />
                <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                    {{ __('Timeline Card Manager') }}</flux:heading>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Create or Update Timeline Cards.') }}
            </p>
        </div>

        <flux:button href="{{ route('admin.timeline') }}" class="bg-gray-600 hover:bg-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            {{ __('Back to Timeline') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="mb-6" />

    <!-- Timeline Card Form -->
    <form wire:submit.prevent="save">
        @if (session()->has('success'))
            <div
                class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg text-green-700 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg text-red-700 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                <flux:heading size="lg" class="mb-4">Timeline Card Details</flux:heading>

                <div class="space-y-5">
                    <div>
                        <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Year</flux:text>
                        <flux:input type="number" id="year" wire:model.defer="year" placeholder="Enter year"
                            class="w-full" min="1000" max="{{ date('Y') + 5 }}" />
                        @error('year')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Description
                            (English)</flux:text>
                        <flux:textarea id="description" wire:model.defer="description"
                            placeholder="Enter description in English" rows="4" class="w-full">
                        </flux:textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Description
                            (Chinese)</flux:text>
                        <flux:textarea id="description_zh" wire:model.defer="description_zh"
                            placeholder="Enter description in Chinese" rows="4" class="w-full">
                        </flux:textarea>
                        @error('description_zh')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 pt-4">
                        <flux:button type="submit" wire:loading.attr="disabled"
                            class="bg-indigo-600 hover:bg-indigo-700 transition-colors text-center py-3">
                            <span wire:loading.remove wire:target="save">
                                {{ $cardId ? 'Update Card' : 'Create Card' }}
                            </span>
                            <span wire:loading wire:target="save">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Processing...
                            </span>
                        </flux:button>

                        <flux:button type="button" href="{{ route('admin.timeline') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:text-white transition-colors text-center py-3">
                            Cancel
                        </flux:button>
                    </div>
                </div>
            </div>

            <!-- Form Debug Info (for development) -->
            @if (config('app.debug'))
                <div class="mt-6 bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Debug Info</flux:heading>
                    <div class="text-xs font-mono overflow-x-auto">
                        <p>Year: {{ $year }}</p>
                        <p>Has Description: {{ !empty($description) ? 'Yes' : 'No' }}</p>
                        <p>Has Chinese Description: {{ !empty($description_zh) ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>