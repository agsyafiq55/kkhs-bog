<div>
    <!-- Page Hero Section -->
    <div class="bg-black relative overflow-hidden p-0 m-0 shadow-md -mx-6 -mt-6 lg:-mx-8 lg:-mt-8">
        <!-- Background image with overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.pexels.com/photos/518543/pexels-photo-518543.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Newspaper"
                alt="Events background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-zinc-700/50 dark:bg-black/50"></div>
        </div>
        <div class="relative z-10 flex flex-col items-center text-center py-16 px-4">
            <!-- Main heading -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-2">Announcements</h1>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold text-red-800 mb-6">公告</h2>

            <!-- Subtitle -->
            <p class="text-gray-300 max-w-2xl mb-2">
                Read the latest news and important updates.<br>阅读最新新闻和重要更新。
            </p>

            <!-- Search and filter section -->
            <div class="w-full max-w-3xl flex flex-col sm:flex-row justify-center items-center gap-2 mt-4">
                {{-- Search Bar --}}
                <div class="w-64">
                    <flux:input icon="magnifying-glass" wire:model.live="search" placeholder="Search by title or content..." />
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto max-w-6xl">
        <!-- Loading Skeleton -->
        <div wire:loading.flex wire:target="search"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 mx-auto max-w-6xl">
            @for ($i = 0; $i < 3; $i++)
                <div
                    class="relative overflow-hidden rounded-lg shadow-md border border-gray-100 dark:border-zinc-800 h-96 bg-white dark:bg-zinc-900 animate-pulse w-full">
                    <div class="h-48 bg-gray-200 dark:bg-zinc-900/50 w-full"></div>
                    <div class="p-5 space-y-4">
                        <div class="h-6 bg-gray-200 dark:bg-zinc-800 rounded w-3/4"></div>
                        <div class="space-y-2">
                            <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded"></div>
                            <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded w-5/6"></div>
                        </div>
                        <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded w-1/4 mt-4"></div>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Results Grid -->
        <div wire:loading.remove wire:target="search" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @forelse($announcements as $announcement)
                <a href="{{ route('announcements.show', $announcement->id) }}"
                    class="block hover:no-underline group">
                    <article class="flex flex-col relative">
                        <!-- Square Image Container -->
                        <div class="aspect-square w-full overflow-hidden rounded-lg">
                            <img src="{{ $announcement->image ? asset('storage/' . $announcement->image) : asset('images/placeholder.jpg') }}"
                                alt="{{ $announcement->title }}"
                                class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105">
                        </div>

                        <!-- Content Section - No Background -->
                        <div>
                            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white line-clamp-2 group-hover:text-red-500 transition-colors">
                                {{ $announcement->title }}
                            </h3>

                            <div class="mt-1 flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $announcement->published_at->format('M d, Y') }}
                                </div>

                                @if ($announcement->publish_end)
                                    <div title="Available until {{ $announcement->publish_end->format('F d, Y') }}">
                                        {{ $announcement->publish_end->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">No announcements found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        @if ($search)
                            Try adjusting your search criteria.
                        @else
                            No announcements available at this time.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
