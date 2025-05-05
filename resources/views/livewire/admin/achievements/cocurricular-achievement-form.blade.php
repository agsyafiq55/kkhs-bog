<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center mb-2">
                <flux:icon name="trophy" class="mr-3 text-amber-600 dark:text-amber-400" />
                <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                    {{ $isEdit ? __('Edit Co-Curricular Achievement') : __('Add Co-Curricular Achievement') }}</flux:heading>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Manage co-curricular achievements and competition results.') }}
            </p>
        </div>

        <div>
            <flux:button href="{{ route('admin.achievements.cocurricular.index') }}"
                class="bg-gray-600 hover:bg-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                {{ __('Back to List') }}
            </flux:button>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Event Title -->
                <div class="md:col-span-2">
                    <flux:input type="text" wire:model="eventTitle" label="Cocurricular Event/Competition Title" 
                        placeholder="eg. MSSD 2025" />
                    @error('eventTitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Category -->
                <div>
                    <flux:select wire:model="category" label="Category">
                        <flux:select.option value="">Select Category</flux:select.option>
                        @foreach ($categories as $cat)
                            <flux:select.option value="{{ $cat }}">{{ $cat }}</flux:select.option>
                        @endforeach
                        <flux:select.option value="Robotics">Robotics</flux:select.option>
                        <flux:select.option value="Sports">Sports</flux:select.option>
                        <flux:select.option value="Debate">Debate</flux:select.option>
                        <flux:select.option value="Academic">Academic</flux:select.option>
                        <flux:select.option value="Arts">Arts</flux:select.option>
                        <flux:select.option value="Music">Music</flux:select.option>
                        <flux:select.option value="Leadership">Leadership</flux:select.option>
                        <flux:select.option value="Community Service">Community Service</flux:select.option>
                    </flux:select>
                    @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Event Date -->
                <div>
                    <flux:input type="date" wire:model="eventDate" label="Event Date" />
                    @error('eventDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <flux:textarea wire:model="description" label="Description (Optional)" rows="4"
                        placeholder="Enter additional details about this achievement" />
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <flux:separator />

            <!-- Achievement Items Section -->
            <div class="mt-6 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Achievement Details
                    </label>
                </div>

                @error('achievementItems')
                    <span class="text-red-500 text-sm block mb-2">{{ $message }}</span>
                @enderror

                <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4 space-y-3">
                    @foreach ($achievementItems as $index => $item)
                        <div class="flex items-center gap-4 p-4 bg-white dark:bg-zinc-900 rounded-md shadow-sm">
                            <div class="flex-1">
                                <flux:input type="text" wire:model="achievementItems.{{ $index }}.achievement" 
                                    label="Achievement" placeholder="e.g. Gold Medal, First Place, etc." />
                                @error("achievementItems.{$index}.achievement")
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <flux:input type="number" wire:model="achievementItems.{{ $index }}.student_count"
                                    label="Student Count" placeholder="Number of students" min="1" />
                                @error("achievementItems.{$index}.student_count")
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <flux:separator vertical />
                            <div class="flex items-end pr-0.5 pb-1">
                                <button type="button" wire:click="removeAchievementItem({{ $index }})"
                                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    @if (empty($achievementItems))
                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                            <p>No achievement details added yet. Click "Add Achievement" to start.</p>
                        </div>
                    @endif
                    <div class="flex justify-end">
                        <flux:button type="button" wire:click="addAchievementItem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline-block" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Add Achievement
                        </flux:button>
                    </div>
                </div>
            </div>

            <div class="flex pt-4 justify-end">
                <flux:button type="submit" class="bg-amber-600 hover:bg-amber-700 transition-colors">
                    {{ $isEdit ? __('Update Achievement') : __('Create Achievement') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>