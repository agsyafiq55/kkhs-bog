<div class="py-6">
    <div class="container mx-auto max-w-6xl px-4">
        <div class="flex justify-between items-center mb-6">
            <flux:button href="{{ route('admin.announcements') }}" class="bg-gray-500 hover:bg-gray-600 transition-colors">
                <flux:icon name="arrow-left" class="mr-2" />
                {{ __('Back to Announcements') }}
            </flux:button>
            
            <flux:button href="{{ route('admin.announcements.edit', $announcement->id) }}" class="bg-indigo-600 hover:bg-indigo-700 transition-colors">
                <flux:icon name="pencil-square" class="mr-2" />
                {{ __('Edit Announcement') }}
            </flux:button>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-zinc-700">
            <div class="p-6">
                <flux:heading size="xl" level="1" class="mb-2">{{ $announcement->title }}</flux:heading>
                
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    Published on {{ $announcement->published_at->format('F d, Y \a\t h:i A') }}
                </div>

                @if($announcement->image)
                    <div class="mb-8">
                        <img src="{{ asset('storage/' . $announcement->image) }}" 
                            alt="{{ $announcement->title }}" 
                            class="w-full h-auto rounded-lg">
                    </div>
                @endif

                <div class="prose prose-indigo max-w-none dark:prose-invert mb-8">
                    <p class="whitespace-pre-line">{{ $announcement->content }}</p>
                </div>
                
                <!-- Publication Status Section -->
                <div class="mt-6 bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                    <flux:heading size="lg" class="mb-4">Publication Status</flux:heading>
                    
                    <div class="flex items-center mb-3">
                        <span class="mr-2 text-gray-700 dark:text-gray-300">Status:</span>
                        @if($isActive)
                            <flux:badge color="green" class="inline-flex items-center">
                                <flux:icon name="check-circle" class="mr-1 h-4 w-4" />
                                Active
                            </flux:badge>
                        @else
                            <flux:badge color="gray" class="inline-flex items-center">
                                <flux:icon name="x-circle" class="mr-1 h-4 w-4" />
                                Inactive
                            </flux:badge>
                        @endif
                    </div>
                    
                    <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <p>Published on: {{ $announcement->published_at->format('F d, Y H:i') }}</p>
                        
                        @if($announcement->publish_start)
                            <p>Publish start: {{ $announcement->publish_start->format('F d, Y H:i') }}</p>
                        @endif
                        
                        @if($announcement->publish_end)
                            <p>Publish end: {{ $announcement->publish_end->format('F d, Y H:i') }}</p>
                        @endif
                        
                        @if(!$announcement->publish_start && !$announcement->publish_end)
                            <p class="italic">No publish range set - announcement is visible based on published date only.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>