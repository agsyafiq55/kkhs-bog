<div class="py-6">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1" class="text-gray-800 dark:text-white">
                {{ __('Announcements Management') }}
            </flux:heading>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Manage school announcements and notices</p>
        </div>

        {{-- Search Bar --}}
        <div class="w-full sm:w-1/3">
            @livewire('search-bar', [
            'model' => 'Announcement',
            'searchFields' => ['title', 'content'],
            'wireKey' => 'announcements-search'
            ])
        </div>

        {{-- Status Filter Dropdown --}}
        <div class="w-full sm:w-auto">
            <flux:select wire:model.live="statusFilter">
                <option value="all">All Announcements</option>
                <option value="active">Active Announcements</option>
                <option value="inactive">Inactive Announcements</option>
            </flux:select>
        </div>

        <flux:button href="{{ route('admin.announcements.create') }}" class="transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline-block" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
            {{ __('Add New Announcement') }}
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

    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Published At
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Publish Range
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse($announcements as $announcement)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $announcement->title }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $announcement->published_at->format('M d, Y H:i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                @if($announcement->isActive())
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                    Active
                                </span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    Inactive
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                @if($announcement->publish_start || $announcement->publish_end)
                                @if($announcement->publish_start)
                                From: {{ $announcement->publish_start->format('M d, Y') }}<br>
                                @endif
                                @if($announcement->publish_end)
                                To: {{ $announcement->publish_end->format('M d, Y') }}
                                @endif
                                @else
                                <span class="text-gray-400 dark:text-gray-500">No range set</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.announcements.show', $announcement->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    View
                                </a>
                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    Edit
                                </a>
                                <button
                                    onclick="event.preventDefault(); Flux.modal('delete-announcement-{{ $announcement->id }}').show();"
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5"
                            class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-500 dark:text-gray-400">
                            No announcements found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Delete confirmation modals -->
    @foreach($announcements as $announcement)
    <flux:modal name="delete-announcement-{{ $announcement->id }}" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete announcement?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete "{{ $announcement->title }}".</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button
                    wire:click="delete({{ $announcement->id }})"
                    onclick="Flux.modal('delete-announcement-{{ $announcement->id }}').close();"
                    variant="danger">
                    Delete announcement
                </flux:button>
            </div>
        </div>
    </flux:modal>
    @endforeach
</div>