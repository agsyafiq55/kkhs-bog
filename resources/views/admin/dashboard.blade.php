<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Greeting Section -->
        <div class="mb-2">
            <flux:heading size="xl">Welcome back, {{ auth()->user()->name }}!</flux:heading>
            <flux:text class="text-gray-600 dark:text-gray-400">
                Here's what's happening with KKHS today.
            </flux:text>
        </div>

        <!-- Statistics Cards -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/60">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Announcements</p>
                <h2 class="mt-2 text-3xl font-bold">{{ \App\Models\Announcement::count() }}</h2>
                <div class="mt-2 flex items-center gap-2">
                    @php
                        $activeCount = \App\Models\Announcement::whereNotNull('published_at')
                            ->where('published_at', '<=', now())
                            ->count();
                        $totalCount = \App\Models\Announcement::count();
                    @endphp
                    <svg class="h-4 w-4 {{ $activeCount > 0 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span class="text-sm font-medium {{ $activeCount > 0 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">
                        {{ $activeCount }}/{{ $totalCount }} Active
                    </span>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/60">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Events</p>
                <h2 class="mt-2 text-3xl font-bold">{{ \App\Models\Event::count() }}</h2>
                <div class="mt-2 flex items-center gap-2">
                    @php
                        $highlightedCount = \App\Models\Event::where('is_highlighted', true)->count();
                        $totalCount = \App\Models\Event::count();
                    @endphp
                    <svg class="h-4 w-4 {{ $highlightedCount > 0 ? 'text-yellow-600 dark:text-yellow-500' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <span class="text-sm font-medium {{ $highlightedCount > 0 ? 'text-yellow-600 dark:text-yellow-500' : 'text-gray-400 dark:text-gray-500' }}">
                        {{ $highlightedCount }}/{{ $totalCount }} Highlighted
                    </span>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/60 sm:col-span-2 lg:col-span-1">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Gallery Collection</p>
                <h2 class="mt-2 text-3xl font-bold">{{ \App\Models\Gallery::count() }}</h2>
                <div class="mt-2 flex items-center gap-2">
                    @php
                        $categoryCount = \App\Models\Gallery::distinct('category')->count('category');
                    @endphp
                    <svg class="h-4 w-4 text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-500">
                        {{ $categoryCount }} Categories
                    </span>
                </div>
            </div>
        </div>

        <!-- Recent Data Section -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Recent Announcements -->
            <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/60">
                <div class="mb-4 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                    <flux:heading size="lg">Recent Announcements</flux:heading>
                    <flux:select id="announcement-filter" class="w-full sm:w-48">
                        <flux:select.option>All</flux:select.option>
                        <flux:select.option value="active">Active Only</flux:select.option>
                        <flux:select.option value="inactive">Inactive Only</flux:select.option>
                    </flux:select>
                </div>
                <div id="announcements-container" class="max-h-80 overflow-y-auto">
                    @foreach(\App\Models\Announcement::orderBy('created_at', 'desc')->take(5)->get() as $announcement)
                        <div class="announcement-item mb-3 rounded-lg border border-neutral-100 bg-neutral-50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50" 
                             data-status="{{ $announcement->isActive() ? 'active' : 'inactive' }}">
                            <h4 class="font-medium">{{ $announcement->title }}</h4>
                            <div class="mt-1 flex flex-wrap items-center gap-x-3 text-sm text-gray-500">
                                <span>{{ $announcement->published_at ? $announcement->published_at->format('d M Y') : 'Not published' }}</span>
                                @if($announcement->isActive())
                                    <flux:badge color="lime">Active</flux:badge>
                                @else
                                    <flux:badge color="red">Inactive</flux:badge>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Events -->
            <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/60">
                <div class="mb-4 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                    <flux:heading size="lg">Recent Events</flux:heading>
                    <flux:select id="event-filter" class="w-full sm:w-48">
                        <flux:select.option>All</flux:select.option>
                        <flux:select.option value="highlighted">Highlighted Only</flux:select.option>
                        <flux:select.option value="regular">Non-Highlighted Only</flux:select.option>
                    </flux:select>
                </div>
                <div id="events-container" class="max-h-80 overflow-y-auto">
                    @foreach(\App\Models\Event::orderBy('event_date', 'desc')->take(5)->get() as $event)
                        <div class="event-item mb-3 rounded-lg border border-neutral-100 bg-neutral-50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50"
                             data-highlight="{{ $event->is_highlighted ? 'highlighted' : 'regular' }}">
                            <h4 class="font-medium">{{ $event->title }}</h4>
                            <div class="mt-1 flex flex-wrap items-center gap-x-3 text-sm text-gray-500">
                                <span>{{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('d M Y') : 'No date' }}</span>
                                @if($event->is_highlighted)
                                    <flux:badge color="yellow">Highlighted</flux:badge>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Academic Achievements Summary -->
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/60">
            <div class="mb-4 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                <flux:heading size="lg">Academic Achievements</flux:heading>
                <flux:select id="academic-filter" class="w-full sm:w-48">
                    <flux:select.option>All Years</flux:select.option>
                    @foreach(\App\Models\AcademicAchievement::distinct()->orderBy('year', 'desc')->pluck('year') as $year)
                        <flux:select.option value="{{ $year }}">{{ $year }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                    <thead>
                        <tr class="bg-neutral-50 dark:bg-zinc-800/50">
                            <th class="whitespace-nowrap px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Exam Type</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Year</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">GPS</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Certificate %</th>
                        </tr>
                    </thead>
                    <tbody id="academic-container" class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @foreach(\App\Models\AcademicAchievement::orderBy('year', 'desc')->take(5)->get() as $achievement)
                            <tr class="academic-item hover:bg-neutral-50 dark:hover:bg-zinc-800/50" data-year="{{ $achievement->year }}">
                                <td class="px-4 py-3 text-sm">{{ $achievement->exam_type }}</td>
                                <td class="px-4 py-3 text-sm">{{ $achievement->year }}</td>
                                <td class="px-4 py-3 text-sm">{{ $achievement->gps }}</td>
                                <td class="px-4 py-3 text-sm">{{ $achievement->certificate_percentage }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Co-curricular Achievements -->
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/60">
            <div class="mb-4 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                <flux:heading size="lg">Co-curricular Achievements</flux:heading>
                <flux:select id="cocurricular-filter" class="w-full sm:w-48">
                    <flux:select.option>All Categories</flux:select.option>
                    @foreach(\App\Models\CocurricularAchievement::distinct()->orderBy('category')->pluck('category') as $category)
                        <flux:select.option value="{{ $category }}">{{ $category }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div id="cocurricular-container" class="max-h-96 space-y-4 overflow-y-auto">
                @foreach(\App\Models\CocurricularAchievement::with('items')->orderBy('event_date', 'desc')->take(5)->get() as $achievement)
                    <div class="cocurricular-item rounded-lg border border-neutral-100 bg-neutral-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/50"
                         data-category="{{ $achievement->category }}">
                        <h4 class="font-medium">{{ $achievement->event_title }}</h4>
                        <p class="mt-1 text-sm text-gray-500">{{ $achievement->category }} - {{ $achievement->event_date ? \Carbon\Carbon::parse($achievement->event_date)->format('d M Y') : 'No date' }}</p>
                        
                        @if($achievement->items->count() > 0)
                            <div class="mt-3 space-y-2 rounded-md bg-white p-3 dark:bg-zinc-800/70">
                                @foreach($achievement->items->take(3) as $item)
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-1.5 rounded-full bg-blue-500"></div>
                                        <p class="text-sm">{{ $item->achievement }} <span class="text-gray-500">({{ $item->student_count }} students)</span></p>
                                    </div>
                                @endforeach
                                @if($achievement->items->count() > 3)
                                    <p class="text-xs text-gray-500">+ {{ $achievement->items->count() - 3 }} more achievements</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Announcement filtering
            const announcementFilter = document.getElementById('announcement-filter');
            announcementFilter.addEventListener('change', function() {
                const selectedValue = this.value;
                const items = document.querySelectorAll('.announcement-item');
                
                items.forEach(item => {
                    if (selectedValue === 'all' || item.dataset.status === selectedValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Event filtering
            const eventFilter = document.getElementById('event-filter');
            eventFilter.addEventListener('change', function() {
                const selectedValue = this.value;
                const items = document.querySelectorAll('.event-item');
                
                items.forEach(item => {
                    if (selectedValue === 'all' || item.dataset.highlight === selectedValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Academic achievements filtering
            const academicFilter = document.getElementById('academic-filter');
            academicFilter.addEventListener('change', function() {
                const selectedValue = this.value;
                const items = document.querySelectorAll('.academic-item');
                
                items.forEach(item => {
                    if (selectedValue === 'all' || item.dataset.year === selectedValue) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Co-curricular achievements filtering
            const cocurricularFilter = document.getElementById('cocurricular-filter');
            cocurricularFilter.addEventListener('change', function() {
                const selectedValue = this.value;
                const items = document.querySelectorAll('.cocurricular-item');
                
                items.forEach(item => {
                    if (selectedValue === 'all' || item.dataset.category === selectedValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
    @endpush
</x-layouts.app>
