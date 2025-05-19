<div class="py-6">
    <!-- Page Header Section -->
    <div class="mb-6">
        <div class="flex items-center mb-2">
            <flux:icon name="information-circle" class="mr-3 h-6 w-6 text-gray-800 dark:text-white" />
            <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                {{ __('Manage Contact Us') }}
            </flux:heading>
        </div>
        <div class="flex justify-between items-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Manage and organize school contact us information.') }}
            </p>
            <flux:button
                href="{{ $contactUs ? route('admin.contactus.edit', ['contactUsId' => $contactUs->id]) : route('admin.contactus.edit') }}"
                class="{{ $contactUs ? 'bg-gray-600 hover:bg-gray-700' : 'bg-red-500 hover:bg-red-600' }} transition-colors">
                <flux:icon name="pencil-square" class="mr-2" />
                {{ $contactUs ? __('Edit Contact Us Info') : __('Add Contact Us Info') }}
            </flux:button>
        </div>
    </div>
    <flux:separator variant="subtle" class="mb-6" />

    @if (!$contactUs)
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-8 border border-gray-100 dark:border-zinc-700 text-center">
        <div class="flex flex-col items-center justify-center py-12">
            <div class="bg-gray-100 dark:bg-zinc-800 rounded-full p-6 mb-6">
                <flux:icon name="information-circle" class="w-12 h-12 text-gray-400" />
            </div>
            <flux:heading size="lg" class="mb-3">No Contact Information Available</flux:heading>
            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
                {{ __('No contact information has been added yet. Please click the button below to add your organization\'s contact details.') }}
            </p>
            <flux:button
                href="{{ route('admin.contactus.edit') }}"
                class="bg-red-500 hover:bg-red-600 transition-colors">
                <flux:icon name="plus" class="mr-2" />
                {{ __('Add Contact Information') }}
            </flux:button>
        </div>
    </div>
    @else
    <!-- Display Contact Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Contact Details Card -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-zinc-700">
            <div class="flex items-center mb-4">
                <div class="bg-red-100 dark:bg-red-900/20 p-3 rounded-lg mr-4">
                    <flux:icon name="information-circle" class="w-6 h-6 text-red-500 dark:text-red-400" />
                </div>
                <flux:heading size="lg" class="text-gray-800 dark:text-white">Basic Information</flux:heading>
            </div>

            <div class="space-y-6 mt-6">
                <div class="flex border-b border-gray-100 dark:border-zinc-800 pb-4">
                    <div class="w-1/3">
                        <flux:text variant="strong" class="text-gray-600 dark:text-gray-400">Address:</flux:text>
                    </div>
                    <div class="w-2/3">
                        <p class="text-gray-800 dark:text-gray-200">{{ $contactUs->address }}</p>
                    </div>
                </div>

                <div class="flex border-b border-gray-100 dark:border-zinc-800 pb-4">
                    <div class="w-1/3">
                        <flux:text variant="strong" class="text-gray-600 dark:text-gray-400">Email:</flux:text>
                    </div>
                    <div class="w-2/3">
                        <a href="mailto:{{ $contactUs->email }}" class="text-red-500 hover:text-red-600 transition-colors">
                            {{ $contactUs->email }}
                        </a>
                    </div>
                </div>

                <div class="flex border-b border-gray-100 dark:border-zinc-800 pb-4">
                    <div class="w-1/3">
                        <flux:text variant="strong" class="text-gray-600 dark:text-gray-400">Phone 1:</flux:text>
                    </div>
                    <div class="w-2/3">
                        <a href="tel:{{ $contactUs->phone_no1 }}" class="text-gray-800 dark:text-gray-200 hover:text-red-500 transition-colors">
                            {{ $contactUs->phone_no1 }}
                        </a>
                    </div>
                </div>

                @if($contactUs->phone_no2)
                <div class="flex pb-2">
                    <div class="w-1/3">
                        <flux:text variant="strong" class="text-gray-600 dark:text-gray-400">Phone 2:</flux:text>
                    </div>
                    <div class="w-2/3">
                        <a href="tel:{{ $contactUs->phone_no2 }}" class="text-gray-800 dark:text-gray-200 hover:text-red-500 transition-colors">
                            {{ $contactUs->phone_no2 }}
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Map Location Card -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700 overflow-hidden h-full">
            @if ($contactUs->map_url)
            <iframe
                src="{{ $contactUs->map_url }}"
                width="100%"
                height="100%"
                class="w-full h-full min-h-[400px]"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            @else
            <div class="flex items-center justify-center h-full min-h-[400px] bg-gray-50 dark:bg-zinc-800">
                <div class="text-center p-6">
                    <flux:icon name="map-pin" class="w-8 h-8 text-gray-400 mx-auto mb-2" />
                    <p class="text-gray-500 dark:text-gray-400">No map location has been provided.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>