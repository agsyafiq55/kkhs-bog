<div>
    <!-- Page Hero Section -->
    <div class="bg-black relative overflow-hidden p-0 m-0 shadow-md -mx-6 -mt-6 lg:-mx-8 lg:-mt-8">
        <!-- Background image with overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/stock-photos/gallery.jpeg') }}" alt="Chinese landscape"
                alt="Events background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-zinc-700/50 dark:bg-black/50"></div>
        </div>
        <div class="relative z-10 flex flex-col items-center text-center py-16 px-4">
            <!-- Main heading -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-2">Gallery</h1>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold text-red-800 mb-6">照片库</h2>

            <!-- Subtitle -->
            <p class="text-gray-300 max-w-2xl mb-2">
                Explore the mesmerizing sceneries and various facilities in Kota Kinabalu High School. <br> 探索亚庇高中迷人的风景和各种设施.
            </p>

            <!-- Search and filter section -->
            <div class="w-full max-w-3xl flex flex-col sm:flex-row justify-center items-center gap-2 mt-4">
                {{-- Dropdown Filter --}}
                <div class="w-64">
                    <flux:select icon="funnel" wire:model.live="selectedCategory">
                        <option value="">All Photos</option>
                        @foreach ($availableCategories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-6xl">
        <!-- Loading Skeleton -->
        <div wire:loading.flex wire:target="selectedCategory"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 mx-auto">
            @for ($i = 0; $i < 3; $i++)
                <div
                    class="relative overflow-hidden rounded-lg shadow-md border border-gray-100 dark:border-zinc-800 h-64 bg-white dark:bg-zinc-900 animate-pulse w-full">
                    <div class="h-full bg-gray-200 dark:bg-zinc-900/50 w-full"></div>
                </div>
            @endfor
        </div>

        <!-- Gallery Content -->
        <div wire:loading.remove wire:target="selectedCategory">
            @if ($images->isEmpty())
                <div class="text-center mt-8 p-8 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">No images found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        @if ($selectedCategory)
                            Try selecting a different category.
                        @else
                            There are no images available at the moment.
                        @endif
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-8">
                    @php
                        // Group images into columns for better layout control
                        $columns = [[], [], []];
                        $i = 0;
                        foreach ($images as $image) {
                            $columns[$i % 3][] = $image;
                            $i++;
                        }

                        // Define possible height classes for randomization
                        $heightClasses = ['h-48', 'h-56', 'h-64', 'h-72'];
                    @endphp

                    @foreach ($columns as $column)
                        <div class="flex flex-col gap-4">
                            @foreach ($column as $image)
                                @php
                                    // Randomly select a height class
                                    $randomHeight = $heightClasses[array_rand($heightClasses)];
                                @endphp

                                <a href="{{ route('gallery.show', $image->id) }}" class="block">
                                    <!-- Card with hover effect -->
                                    <div
                                        class="w-full {{ $randomHeight }} shadow-lg rounded-lg overflow-hidden relative transform-gpu preserve-3d perspective-1000 transition-all duration-500 ease-in-out cursor-pointer hover:rotate-y-10 hover:rotate-x-10 hover:scale-105 hover:shadow-lg group">
                                        <!-- Background image with gradient overlay -->
                                        <div class="absolute inset-0 overflow-hidden">
                                            <img class="w-full h-full object-cover"
                                                <img class="w-full h-full object-cover"
                                                src="{{ asset('storage/' . $image->image) }}" 
                                                alt="Event Thumbnail">
                                        </div>

                                        <!-- Gradient overlay that appears on hover -->
                                        <div
                                            class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>

                                        <!-- Before pseudo-element -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-b from-transparent to-black/10 z-10 transform transition-transform duration-500 ease-in-out group-hover:-translate-x-full">
                                        </div>

                                        <!-- After pseudo-element -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-b from-transparent to-black/10 z-10 transform transition-transform duration-500 ease-in-out group-hover:translate-x-full">
                                        </div>

                                        <!-- Card content - only visible on hover -->
                                        <div
                                            class="p-5 relative z-20 flex flex-col gap-2 items-center justify-center text-center h-full text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <h3 class="text-xl font-bold uppercase">{{ $image->img_name }}</h3>
                                            @if ($image->description)
                                                <p class="text-white/80 text-sm">
                                                    {{ Str::limit($image->description, 60) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
