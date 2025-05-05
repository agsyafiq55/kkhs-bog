<div class="p-6">
    <div class="mb-6">
        <flux:heading size="xl" level="1">{{ $announcement->title }}</flux:heading>
        <flux:subheading size="lg">{{ __('Announcement Details') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="mb-4">
        <flux:text variant="strong">Published At:</flux:text>
        <span>{{ $announcement->published_at->format('F d, Y H:i') }}</span>
    </div>

    <div class="mb-4">
        <flux:text variant="strong">Content:</flux:text>
        <p class="mt-2 whitespace-pre-line">{{ $announcement->content }}</p>
    </div>

    @if($announcement->image)
        <div class="mb-4">
            <flux:text variant="strong">Image:</flux:text>
            <div class="mt-2">
                <img src="{{ asset('storage/' . $announcement->image) }}" 
                     class="max-w-full h-auto rounded-lg shadow-md" alt="Announcement image">
            </div>
        </div>
    @endif

    <!-- Publication Status Section -->
    <div class="mt-6 bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Publication Status</h3>
        
        <div class="flex items-center mb-2">
            <span class="mr-2">Status:</span>
            @if($isActive)
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                    Active
                </span>
            @else
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                    Inactive
                </span>
            @endif
        </div>
        
        <div class="text-sm text-gray-600 dark:text-gray-400">
            <p>Published on: {{ $announcement->published_at->format('F d, Y H:i') }}</p>
            
            @if($announcement->publish_start)
                <p class="mt-1">Publish start: {{ $announcement->publish_start->format('F d, Y H:i') }}</p>
            @endif
            
            @if($announcement->publish_end)
                <p class="mt-1">Publish end: {{ $announcement->publish_end->format('F d, Y H:i') }}</p>
            @endif
            
            @if(!$announcement->publish_start && !$announcement->publish_end)
                <p class="mt-1">No publish range set - announcement is visible based on published date only.</p>
            @endif
        </div>
    </div>

    <div class="mt-6">
        <flux:button href="{{ route('admin.announcements') }}" class="bg-gray-500 text-white p-2 rounded">
            {{ __('Back to Announcements') }}
        </flux:button>
    </div>
</div>