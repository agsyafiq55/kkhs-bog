<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center mb-2">
                <flux:icon name="phone" class="mr-3 text-indigo-600 dark:text-indigo-400" />
                <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                    {{ $contactUsId ? 'Edit Contact Us Details' : 'Create Contact Us Details' }}
                </flux:heading>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Manage contact information for the organization.') }}
            </p>
        </div>

        <flux:button href="{{ route('admin.contactus.display') }}"
            class="bg-gray-600 hover:bg-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            {{ __('Back to Contact Us') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="mb-6" />

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg text-green-700 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg text-red-700 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Contact Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
                    <flux:heading size="lg" class="mb-4">Contact Information</flux:heading>

                    <div class="space-y-5">
                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Address</flux:text>
                            <flux:input type="text" id="address" wire:model="address"
                                placeholder="Enter address" class="w-full" />
                            @error('address')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Email</flux:text>
                            <flux:input type="email" id="email" wire:model="email"
                                placeholder="Enter email" class="w-full" />
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Phone Number 1</flux:text>
                            <flux:input type="text" id="phone_no1" wire:model="phone_no1"
                                placeholder="Enter phone number 1" class="w-full" />
                            @error('phone_no1')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Phone Number 2</flux:text>
                            <flux:input type="text" id="phone_no2" wire:model="phone_no2"
                                placeholder="Enter phone number 2" class="w-full" />
                            @error('phone_no2')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <flux:text variant="strong" class="mb-2 block text-gray-700 dark:text-gray-300">Maps Coordinate</flux:text>
                            <flux:input type="text" id="map_url" wire:model="map_url"
                                placeholder="Enter Google Maps URL" class="w-full" />
                            @error('map_url')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Changes Button -->
        <div class="mt-6">
            <flux:button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                {{ __('Save Changes') }}
            </flux:button>
        </div>
    </form>
</div>