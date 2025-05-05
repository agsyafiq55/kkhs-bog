<x-layouts.app>
    <x-slot name="title">{{ $announcement->title }}</x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('announcements.index') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Announcements
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-zinc-700">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $announcement->title }}</h1>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        Published on {{ $announcement->published_at->format('F d, Y \a\t h:i A') }}
                    </div>

                    <div class="mb-8">
                        <img src="{{ $announcement->image ? asset('storage/' . $announcement->image) : asset('images/placeholder.jpg') }}" 
                             alt="{{ $announcement->title }}" 
                             class="w-full h-auto rounded-lg">
                    </div>

                    <div class="prose prose-indigo max-w-none dark:prose-invert">
                        <p class="whitespace-pre-line">{{ $announcement->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>