<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center mb-2">
                <flux:icon name="photo" class="mr-3 text-indigo-600 dark:text-indigo-400" />
                <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                    {{ __('Gallery Manager') }}</flux:heading>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Create, View, Update or Delete Gallery Images.') }}
            </p>
        </div>

        <flux:button href="{{ route('admin.gallery') }}" class="bg-gray-600 hover:bg-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            {{ __('Back to Gallery') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="mb-6" />

    <!-- Gallery Form -->
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <!-- Add form status messages -->
        @if (session()->has('message'))
            <div
                class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg text-green-700 dark:text-green-400">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg text-red-700 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Debug Info (for development) -->
        @if (!empty($debugInfo))
            <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-700 dark:text-gray-300">
                <pre class="text-xs">{{ $debugInfo }}</pre>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Details -->
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Image Details</flux:heading>

                    <div class="space-y-5">
                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Image Name
                            </flux:text>
                            <flux:input type="text" id="img_name" wire:model.defer="img_name"
                                placeholder="Enter image name" class="w-full" />
                            @error('img_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Category
                            </flux:text>
                            <flux:select id="category" wire:model.defer="category" class="w-full">
                                <flux:select.option value="">Choose Category..</flux:select.option>
                                <flux:select.option value="School Compound">School Compound</flux:select.option>
                                <flux:select.option value="Facilities">Facilities</flux:select.option>
                                <flux:select.option value="Garden and Orchard">Garden and Orchard</flux:select.option>
                                <flux:select.option value="Other">Other</flux:select.option>
                            </flux:select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Description
                            </flux:text>
                            <flux:textarea id="description" wire:model.defer="description"
                                placeholder="Brief description of the image" rows="3" class="w-full">
                            </flux:textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Image Upload and Actions -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Image Upload</flux:heading>

                    <div>
                        <!-- Image Preview -->
                        <!-- Replace the image preview section -->
                        <div class="mb-4 relative rounded-lg overflow-hidden bg-gray-100 dark:bg-zinc-800 aspect-video flex items-center justify-center">
                            @if($newImage)
                                <img src="{{ $newImage->temporaryUrl() }}" class="w-full h-full object-cover" alt="Image preview">
                            @elseif($galleryId && isset($gallery) && $gallery->image)
                                <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover" alt="Current image">
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
                        <input type="file" id="newImage" wire:model="newImage"
                            class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                dark:text-gray-400 dark:file:bg-zinc-700 dark:file:text-zinc-100"
                            accept="image/*" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WebP - Max 5MB</p>
                        @error('newImage')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        
                        <div wire:loading wire:target="newImage" class="mt-2 text-sm text-indigo-600 dark:text-indigo-400">
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

                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Actions</flux:heading>

                    <div class="space-y-3">
                        <flux:button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 transition-colors text-center py-3">
                            <span wire:loading.remove
                                wire:target="save">{{ $galleryId ? 'Update Image' : 'Add Image' }}</span>
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

                        <flux:button type="button" href="{{ route('admin.gallery') }}"
                            class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:text-white transition-colors text-center py-3">
                            Cancel
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>