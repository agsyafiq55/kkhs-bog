<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center mb-2">
                <flux:icon name="user-group" class="mr-3 text-indigo-600 dark:text-indigo-400" />
                <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                    {{ $memberId ? 'Edit Member' : 'Create Member' }}
                </flux:heading>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Manage board members information and photos.') }}
            </p>
        </div>

        <flux:button href="{{ route('admin.aboutus.members.list') }}"
            class="bg-gray-600 hover:bg-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            {{ __('Back to Members') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="mb-6" />

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

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Member Details -->
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Member Information</flux:heading>

                    <div class="space-y-5">
                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Member Name
                            </flux:text>
                            <flux:input type="text" id="member_name" wire:model="member_name"
                                placeholder="Enter member name" class="w-full" />
                            @error('member_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Chinese Name
                            </flux:text>
                            <flux:input type="text" id="zh_member_name" wire:model="zh_member_name"
                                placeholder="Enter Chinese name" class="w-full" />
                            @error('zh_member_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Position
                            </flux:text>
                            <flux:select id="position" wire:model.live="position" class="w-full">
                                <flux:select.option value="">Choose Position...</flux:select.option>
                                <flux:select.option value="Chairman">Chairman</flux:select.option>
                                <flux:select.option value="Vice Chairman I">Vice Chairman I</flux:select.option>
                                <flux:select.option value="Vice Chairman II">Vice Chairman II</flux:select.option>
                                <flux:select.option value="Secretary">Secretary</flux:select.option>
                                <flux:select.option value="Treasurer">Treasurer</flux:select.option>
                                <flux:select.option value="Supervision">Supervision</flux:select.option>
                                <flux:select.option value="Member of Board of Governor">Member of Board of Governor
                                </flux:select.option>
                            </flux:select>
                            @error('position')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Year -->
                        <div>
                            <flux:select wire:model="year" label="Year">
                                <flux:select.option value="">Select Year</flux:select.option>
                                @foreach ($availableYears as $yearRange)
                                    <flux:select.option value="{{ $yearRange }}">{{ $yearRange }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            @error('year')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Photo and Actions -->
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Member Photo</flux:heading>

                    <div>
                        <!-- Photo Preview -->
                        <div
                            class="mb-4 relative rounded-lg overflow-hidden bg-gray-100 dark:bg-zinc-800 aspect-square flex items-center justify-center">
                            @if ($newPhoto)
                                <img src="{{ $newPhoto->temporaryUrl() }}" class="w-full h-full object-cover"
                                    alt="Member photo preview">
                            @elseif($memberId && $member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}"
                                    class="w-full h-full object-cover" alt="Current Member Photo">
                            @else
                                <div class="text-center p-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No photo selected</p>
                                </div>
                            @endif
                        </div>

                        <!-- File Upload -->
                        <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Upload Photo
                        </flux:text>
                        <input type="file" id="member_photo" wire:model="newPhoto"
                            class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                dark:text-gray-400 dark:file:bg-zinc-700 dark:file:text-zinc-100"
                            accept="image/*" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WebP - Max 5MB</p>
                        @error('newPhoto')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <div wire:loading wire:target="newPhoto"
                            class="mt-2 text-sm text-indigo-600 dark:text-indigo-400">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
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
                        <flux:button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 transition-colors text-center py-3">
                            <span wire:loading.remove
                                wire:target="save">{{ $memberId ? 'Update Member' : 'Create Member' }}</span>
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

                        <flux:button type="button" href="{{ route('admin.aboutus') }}"
                            class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:text-white transition-colors text-center py-3">
                            Cancel
                        </flux:button>
                    </div>
                </div>

                @if ($debugInfo)
                    <div
                        class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                        <flux:heading size="lg" class="mb-4">Debug Info</flux:heading>
                        <div class="text-xs font-mono overflow-x-auto">
                            <pre>{{ $debugInfo }}</pre>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
