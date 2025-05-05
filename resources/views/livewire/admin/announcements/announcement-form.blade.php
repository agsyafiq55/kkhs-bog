<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center mb-2">
                <flux:icon name="megaphone" class="mr-3 text-indigo-600 dark:text-indigo-400" />
                <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                    {{ $isEdit ? __('Edit Announcement') : __('Create Announcement') }}
                </flux:heading>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ $isEdit ? __('Update announcement details') : __('Create a new school announcement') }}
            </p>
        </div>

        <flux:button href="{{ route('admin.announcements') }}" class="bg-gray-600 hover:bg-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            {{ __('Back to Announcements') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="mb-6" />

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Announcement Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Announcement Information</flux:heading>

                    <div class="space-y-5">
                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Announcement Title</flux:text>
                            <flux:input type="text" id="title" wire:model="title" 
                                placeholder="Enter announcement title" class="w-full" />
                            @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Content</flux:text>
                            <flux:textarea id="content" wire:model="content" rows="8"
                                placeholder="Enter announcement content" class="w-full" />
                            @error('content') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Publication Period</flux:text>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <flux:text variant="small" class="mb-1 block text-gray-600 dark:text-gray-400">Start Date</flux:text>
                                    <flux:input 
                                        type="date" 
                                        id="publish_start"
                                        wire:model="publish_start"
                                        class="w-full" 
                                    />
                                    @error('publish_start')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <flux:text variant="small" class="mb-1 block text-gray-600 dark:text-gray-400">End Date</flux:text>
                                    <flux:input 
                                        type="date" 
                                        id="publish_end"
                                        wire:model="publish_end"
                                        class="w-full" 
                                    />
                                    @error('publish_end')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('If no dates are selected, the announcement will be published immediately and remain active indefinitely.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Image Upload and Actions -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Announcement Image</flux:heading>

                    <div class="space-y-5">
                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">
                                {{ $isEdit ? 'Update Image' : 'Upload Image' }}
                            </flux:text>
                            <input type="file" wire:model="image" accept="image/*" class="w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                dark:file:bg-indigo-900 dark:file:text-indigo-300
                                dark:hover:file:bg-indigo-800
                            "/>
                            @error('image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            
                            <div wire:loading wire:target="image" class="mt-2 text-sm text-indigo-600 dark:text-indigo-400">
                                Uploading...
                            </div>
                        </div>

                        <!-- Replace the current image display section -->
                        @if($isEdit && $currentImage)
                            <div>
                                <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Current Image</flux:text>
                                <div class="mt-2 border border-gray-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $currentImage) }}" alt="Current Announcement Image" class="w-full h-auto">
                                </div>
                            </div>
                        @endif

                        @if($image && !$errors->has('image'))
                            <div>
                                <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Image Preview</flux:text>
                                <div class="mt-2 border border-gray-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                                    <img src="{{ $image->temporaryUrl() }}" alt="New Announcement Image" class="w-full h-auto">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Actions</flux:heading>
                    <div class="flex justify-end">
                        <flux:button type="submit" class="bg-indigo-600 hover:bg-indigo-700 transition-colors">
                            {{ $isEdit ? __('Update Announcement') : __('Create Announcement') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>