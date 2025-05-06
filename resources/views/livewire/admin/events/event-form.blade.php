<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center mb-2">
                <flux:icon name="calendar" class="mr-3 text-indigo-600 dark:text-indigo-400" />
                <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                    {{ __('Events Manager') }}</flux:heading>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Create, View, Update or Delete Events.') }}
            </p>
        </div>

        <flux:button href="{{ route('admin.events') }}" class="bg-gray-600 hover:bg-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            {{ __('Back to Events') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="mb-6" />

    <!-- Event Form -->
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <!-- Add form status messages -->
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Details -->
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Event Details</flux:heading>

                    <div class="space-y-5">
                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Title
                            </flux:text>
                            <flux:input type="text" id="title" wire:model.defer="title"
                                placeholder="Enter event title" class="w-full" />
                            @error('title')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Description
                            </flux:text>
                            <flux:textarea id="description" wire:model.defer="description"
                                placeholder="Brief description of the event" rows="3" class="w-full">
                            </flux:textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Event
                                    Date</flux:text>
                                <flux:input type="date" id="event_date" wire:model.defer="event_date"
                                    class="w-full" />
                                @error('event_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Tag
                                </flux:text>
                                <flux:select id="tag" wire:model.defer="tag" class="w-full">
                                    <flux:select.option value="">Choose Tag..</flux:select.option>
                                    <flux:select.option value="Sports">Sports</flux:select.option>
                                    <flux:select.option value="Education">Education</flux:select.option>
                                    <flux:select.option value="Technology">Technology</flux:select.option>
                                    <flux:select.option value="Culture">Culture</flux:select.option>
                                    <flux:select.option value="Entertainment">Entertainment</flux:select.option>
                                    <flux:select.option value="Health">Health</flux:select.option>
                                    <flux:select.option value="Business">Business</flux:select.option>
                                    <flux:select.option value="Environment">Environment</flux:select.option>
                                    <flux:select.option value="Art">Art</flux:select.option>
                                    <flux:select.option value="Science">Science</flux:select.option>
                                </flux:select>
                                @error('tag')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Article Content</flux:heading>

                    {{-- pass both the model name and the current HTML content --}}
                    <livewire:quill-editor model="article" :content="$article" key="quill-editor-article" />

                    @error('article')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column - Thumbnail and Actions -->
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Thumbnail</flux:heading>

                    <div>
                        <!-- Thumbnail Preview -->
                        <div
                            class="mb-4 relative overflow-hidden bg-gray-100 dark:bg-zinc-800 aspect-video flex items-center justify-center">
                            @if ($thumbnail && !is_string($thumbnail))
                                <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover"
                                    alt="Thumbnail preview">
                            @elseif(isset($event) && $event->thumbnail)
                                <img src="{{ asset('storage/' . $event->thumbnail) }}"
                                    class="w-full h-full object-cover" alt="Thumbnail preview">
                            @else
                                <div class="text-center p-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M8 12h.01M12 12h.01M16 12h.01M20 12h.01M4 12h.01M8 16h.01M12 16h.01" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No image selected</p>
                                </div>
                            @endif
                        </div>

                        <!-- File Upload -->
                        <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Upload Image
                        </flux:text>
                        <input type="file" id="thumbnail" wire:model="thumbnail"
                            class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                dark:text-gray-400 dark:file:bg-zinc-700 dark:file:text-zinc-100"
                            accept="image/*" />
                            @csrf
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WebP - Max 5MB</p>
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <div wire:loading wire:target="thumbnail"
                            class="mt-2 text-sm text-indigo-600 dark:text-indigo-400">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline-block"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Uploading...
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Actions</flux:heading>

                    <div class="space-y-3">
                        <!-- Highlight toggle switch -->
                        <flux:field variant="inline">
                            <flux:heading class="flex items-center gap-2">
                                Highlight this event?
                                <flux:tooltip toggleable>
                                    <flux:button icon="information-circle" size="sm" variant="ghost" />
                                    <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                        <p>Highlighting an event will make sure that the event will always be displayed
                                            at the top of the Events Display Page.</p>
                                    </flux:tooltip.content>
                                </flux:tooltip>
                            </flux:heading>
                            <flux:switch wire:model.defer="is_highlighted" :value="1"
                                :checked="$is_highlighted == 1" />
                            <flux:error name="is_highlighted" />
                        </flux:field>

                        <flux:button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 transition-colors text-center py-3">
                            <span wire:loading.remove
                                wire:target="save">{{ $eventId ? 'Update Event' : 'Create Event' }}</span>
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

                        <flux:button type="button" href="{{ route('admin.events') }}"
                            class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:text-white transition-colors text-center py-3">
                            Cancel
                        </flux:button>
                    </div>
                </div>

                <!-- Form Debug Info (for development) -->
                @if (config('app.debug'))
                    <div
                        class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                        <flux:heading size="lg" class="mb-4">Debug Info</flux:heading>
                        <div class="text-xs font-mono overflow-x-auto">
                            <p>Title: {{ $title }}</p>
                            <p>Description: {{ $description }}</p>
                            <p>Event Date: {{ $event_date }}</p>
                            <p>Tag: {{ $tag }}</p>
                            <p>Has Article: {{ !empty($article) ? 'Yes' : 'No' }}</p>
                            <p>Has Thumbnail: {{ $thumbnail ? 'Yes' : 'No' }}</p>
                            <p>Is Highlighted: {{ $is_highlighted ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
