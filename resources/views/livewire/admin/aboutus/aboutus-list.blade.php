<div class="py-6">
    <!-- Page Header Section -->
    <div class="mb-6">
        <div class="flex items-center mb-2">
            <flux:icon name="information-circle" class="mr-3 h-6 w-6 text-indigo-600 dark:text-indigo-400" />
            <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                {{ __('About Us Management') }}</flux:heading>
        </div>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Manage school about us information.') }}
        </p>
    </div>

    <!-- Controls Section with Background -->
    <div class="mb-6 p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-zinc-700">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Year Filter -->
            <div class="w-full sm:w-2/3 flex flex-col gap-2">
                <!-- Filter Label -->
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Select Year') }}
                </div>
                
                <!-- Year Filter Dropdown -->
                <div class="w-full sm:w-1/2">
                    <flux:select wire:model.live="selectedYear">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <!-- Add Button -->
            <div>
                <flux:button href="{{ route('admin.aboutus.create') }}"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __('Add About Us') }}
                </flux:button>
            </div>
        </div>
    </div>

    <!-- Status Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 dark:border-green-600 rounded-lg text-green-700 dark:text-green-400 flex items-center">
            <flux:icon name="check-circle" class="h-5 w-5 mr-2 text-green-500 dark:text-green-400" />
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 dark:border-red-600 rounded-lg text-red-700 dark:text-red-400 flex items-center">
            <flux:icon name="exclamation-circle" class="h-5 w-5 mr-2 text-red-500 dark:text-red-400" />
            {{ session('error') }}
        </div>
    @endif

    <!-- About Us Content Section -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
        @if ($aboutUsData)
            <div class="mb-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                    {{ __('About Us Information for') }} {{ $selectedYear }}
                </h2>
                
                <!-- Edit Button -->
                <flux:button href="{{ route('admin.aboutus.edit', $aboutUsData->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    {{ __('Edit Info') }}
                </flux:button>
            </div>
            
            <!-- About Us Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Organization Photo -->
                <div class="bg-gray-50 dark:bg-zinc-800 p-6 rounded-lg border border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Organization Photo</h3>
                    <!-- Replace the organization photo display section -->
                    @if($aboutUsData->organization_photo)
                        <div class="aspect-video relative overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $aboutUsData->organization_photo) }}" 
                                 class="w-full h-full object-cover"
                                 alt="Organization Photo">
                        </div>
                    @else
                        <div class="text-center p-8 bg-gray-100 dark:bg-zinc-700 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">No organization photo available</p>
                        </div>
                    @endif
                </div>
            
                <!-- Chairman Photo -->
                <div class="bg-gray-50 dark:bg-zinc-800 p-6 rounded-lg border border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Chairman Photo</h3>
                    <!-- Replace the chairman photo display section -->
                    @if($aboutUsData->chairman_photo)
                        <div class="aspect-video relative overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $aboutUsData->chairman_photo) }}" 
                                 class="w-full h-full object-cover"
                                 alt="Chairman Photo">
                        </div>
                    @else
                        <div class="text-center p-8 bg-gray-100 dark:bg-zinc-700 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">No chairman photo available</p>
                        </div>
                    @endif
                </div>
            
                <!-- Chairman Speech -->
                <div class="col-span-1 lg:col-span-2 bg-gray-50 dark:bg-zinc-800 p-6 rounded-lg border border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Chairman Speech</h3>
                    @if($aboutUsData->chairman_speech)
                        <div class="prose prose-indigo dark:prose-invert max-w-none" lang="zh">
                            {!! $aboutUsData->chairman_speech !!}
                        </div>
                    @else
                        <div class="text-center p-8 bg-gray-100 dark:bg-zinc-700 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">No chairman speech available</p>
                        </div>
                    @endif
                </div>
            
                <!-- Delete Button -->
                <div class="col-span-1 lg:col-span-2 mt-4 flex justify-end">
                    <flux:button 
                        onclick="event.stopPropagation(); Flux.modal('delete-aboutus').show();"
                        class="bg-red-600 hover:bg-red-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Delete') }}
                    </flux:button>
                </div>
            </div>
        @else
            <div class="text-center py-16 bg-gray-50 dark:bg-zinc-800/50 rounded-lg border border-dashed border-gray-300 dark:border-zinc-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-2">No About Us information found for {{ $selectedYear }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">Get started by adding About Us information for this year.</p>
                
                <flux:button href="{{ route('admin.aboutus.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __('Add About Us Information') }}
                </flux:button>
            </div>
        @endif
    </div>
    
    @if($aboutUsData)
    <!-- Delete confirmation modal -->
    <flux:modal name="delete-aboutus" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete About Us information?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete the About Us information for {{ $selectedYear }}.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button 
                    wire:click="deleteAboutUs({{ $aboutUsData->id }})" 
                    onclick="Flux.modal('delete-aboutus').close();"
                    variant="danger">
                    Delete information
                </flux:button>
            </div>
        </div>
    </flux:modal>
    @endif
</div>