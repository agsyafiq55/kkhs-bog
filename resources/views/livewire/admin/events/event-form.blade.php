<div class="py-6">
    <!-- Your existing header content -->

    <!-- Event Form -->
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <!-- Your existing status messages -->

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Details -->
            <!-- No changes needed here -->

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
                        
                        <!-- CSRF token - make sure it's above the file input -->
                        @csrf
                        
                        <!-- Modified file input with x-data attribute -->
                        <div x-data="{ uploading: false, progress: 0 }"
                             x-on:livewire-upload-start="uploading = true"
                             x-on:livewire-upload-finish="uploading = false"
                             x-on:livewire-upload-error="uploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            
                            <input type="file" id="thumbnail" wire:model="thumbnail"
                                class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100
                                    dark:text-gray-400 dark:file:bg-zinc-700 dark:file:text-zinc-100"
                                accept="image/*" />
                                
                            <!-- Progress bar for uploads -->
                            <div x-show="uploading">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" x-bind:style="'width: ' + progress + '%'"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Uploading: <span x-text="progress + '%'"></span></p>
                            </div>
                        </div>
                        
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
                        
                        @if(!empty($debugInfo))
                            <p class="mt-1 text-xs text-green-500">{{ $debugInfo }}</p>
                        @endif
                    </div>
                </div>

                <!-- Existing actions section remains the same -->
            </div>
        </div>
    </form>
</div>