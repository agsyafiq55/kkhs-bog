<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center mb-2">
                <flux:icon name="academic-cap" class="mr-3 text-indigo-600 dark:text-indigo-400" />
                <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                    {{ $isEdit ? __('Edit Academic Achievement') : __('Add Academic Achievement') }}</flux:heading>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Manage academic achievements and examination results.') }}
            </p>
        </div>

        <div>
            <flux:button href="{{ route('admin.achievements.academic.index') }}"
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
                <!-- Exam Type -->
                <div>
                    <flux:select wire:model="examType" label="Exam Type">
                        <flux:select.option value="">Select Exam Type</flux:select.option>
                        <flux:select.option value="SPM">SPM</flux:select.option>
                        <flux:select.option value="STPM">STPM</flux:select.option>
                    </flux:select>
                    @error('examType')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Year -->
                <div>
                    <flux:select wire:model="year" label="Year">
                        <flux:select.option value="">Select Year</flux:select.option>
                        @for ($i = date('Y'); $i >= 2000; $i--)
                            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                        @endfor
                    </flux:select>
                    @error('year')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- GPS -->
                <div>
                    <flux:input type="number" wire:model="gps" label="GPS (Grade Point Score)" placeholder="e.g., 4.46"
                        min="0" max="5" step="0.01" />
                    @error('gps')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Certificate Percentage -->
                <div>
                    <flux:input type="number" wire:model="certificatePercentage"
                        label="Certificate Qualification Percentage" placeholder="e.g., 81.7" min="0"
                        max="100" step="0.01" suffix="%" />
                    @error('certificatePercentage')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <flux:separator />
            <!-- Rest of the form remains unchanged -->
            <!-- Grades Section -->
            <div class="mt-6 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grades & Student
                        Counts</label>
                </div>

                @error('grades')
                    <span class="text-red-500 text-sm block mb-2">{{ $message }}</span>
                @enderror

                <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4 space-y-3">
                    @foreach ($grades as $index => $grade)
                        <div class="flex items-center gap-4 p-4 bg-white dark:bg-zinc-900 rounded-md shadow-sm">
                            <div class="flex-1">
                                <flux:input type="text" wire:model="grades.{{ $index }}.grade" label="Grade"
                                    placeholder="e.g., 10A, 9A" />
                                @error("grades.{$index}.grade")
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <flux:input type="number" wire:model="grades.{{ $index }}.student_count"
                                    label="Student Count" placeholder="Number of students" min="0" />
                                @error("grades.{$index}.student_count")
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <flux:separator vertical />
                            <div class="flex items-end pr-0.5 pb-1">
                                <button type="button" wire:click="removeGrade({{ $index }})"
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

                    @if (count($grades) === 0)
                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                            <p>No grades added yet. Click "Add Grade" to start.</p>
                        </div>
                    @endif
                    <div class="flex justify-end">
                        <flux:button type="button" wire:click="addGrade">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline-block" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Add Grade
                    </flux:button>
                </div>
            </div>

            <div class="flex pt-4 justify-end">
                <flux:button type="submit" class="bg-indigo-600 hover:bg-indigo-700 transition-colors">
                    {{ $isEdit ? __('Update Achievement') : __('Create Achievement') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>
