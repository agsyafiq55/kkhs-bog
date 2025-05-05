<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Statistics Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="overflow-hidden rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Announcements</p>
                    <h2 class="text-2xl font-bold mb-1">{{ \App\Models\Announcement::count() }}</h2>
                    <div class="flex items-center gap-2">
                        @php
                            $activeCount = \App\Models\Announcement::whereNotNull('published_at')->where('published_at', '<=', now())->count();
                            $percentage = \App\Models\Announcement::count() > 0 
                                ? round(($activeCount / \App\Models\Announcement::count()) * 100, 1) 
                                : 0;
                        @endphp
                        <svg class="w-4 h-4 {{ $percentage >= 50 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span class="text-sm {{ $percentage >= 50 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">
                            {{ $percentage }}% Active
                        </span>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Events</p>
                    <h2 class="text-2xl font-bold mb-1">{{ \App\Models\Event::count() }}</h2>
                    <div class="flex items-center gap-2">
                        @php
                            $highlightedCount = \App\Models\Event::where('is_highlighted', true)->count();
                            $eventPercentage = \App\Models\Event::count() > 0 
                                ? round(($highlightedCount / \App\Models\Event::count()) * 100, 1) 
                                : 0;
                        @endphp
                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <span class="text-sm text-yellow-600 dark:text-yellow-500">
                            {{ $eventPercentage }}% Highlighted
                        </span>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Gallery Collection</p>
                    <h2 class="text-2xl font-bold mb-1">{{ \App\Models\Gallery::count() }}</h2>
                    <div class="flex items-center gap-2">
                        @php
                            $categoryCount = \App\Models\Gallery::distinct('category')->count('category');
                        @endphp
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-blue-600 dark:text-blue-500">
                            {{ $categoryCount }} Categories
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Data Section -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Recent Announcements -->
            <div class="overflow-hidden rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                <h3 class="text-lg font-semibold mb-3">Recent Announcements</h3>
                <div class="overflow-y-auto max-h-64">
                    @foreach(\App\Models\Announcement::orderBy('created_at', 'desc')->take(5)->get() as $announcement)
                        <div class="mb-3 pb-3 border-b border-neutral-200 dark:border-neutral-700">
                            <h4 class="font-medium">{{ $announcement->title }}</h4>
                            <p class="text-sm text-gray-500">
                                {{ $announcement->published_at ? $announcement->published_at->format('d M Y') : 'Not published' }}
                                @if($announcement->isActive())
                                    <span class="text-green-500 ml-2">● Active</span>
                                @else
                                    <span class="text-red-500 ml-2">● Inactive</span>
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Events -->
            <div class="overflow-hidden rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                <h3 class="text-lg font-semibold mb-3">Recent Events</h3>
                <div class="overflow-y-auto max-h-64">
                    @foreach(\App\Models\Event::orderBy('event_date', 'desc')->take(5)->get() as $event)
                        <div class="mb-3 pb-3 border-b border-neutral-200 dark:border-neutral-700">
                            <h4 class="font-medium">{{ $event->title }}</h4>
                            <p class="text-sm text-gray-500">
                                {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('d M Y') : 'No date' }}
                                @if($event->is_highlighted)
                                    <span class="text-yellow-500 ml-2">★ Highlighted</span>
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Academic Achievements Summary -->
        <div class="overflow-hidden rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
            <h3 class="text-lg font-semibold mb-3">Academic Achievements</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Exam Type</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Year</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">GPS</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Certificate %</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @foreach(\App\Models\AcademicAchievement::orderBy('year', 'desc')->take(5)->get() as $achievement)
                            <tr>
                                <td class="px-4 py-2 text-sm">{{ $achievement->exam_type }}</td>
                                <td class="px-4 py-2 text-sm">{{ $achievement->year }}</td>
                                <td class="px-4 py-2 text-sm">{{ $achievement->gps }}</td>
                                <td class="px-4 py-2 text-sm">{{ $achievement->certificate_percentage }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Co-curricular Achievements -->
        <div class="overflow-hidden rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
            <h3 class="text-lg font-semibold mb-3">Co-curricular Achievements</h3>
            <div class="overflow-y-auto max-h-64">
                @foreach(\App\Models\CocurricularAchievement::with('items')->orderBy('event_date', 'desc')->take(5)->get() as $achievement)
                    <div class="mb-4 pb-3 border-b border-neutral-200 dark:border-neutral-700">
                        <h4 class="font-medium">{{ $achievement->event_title }}</h4>
                        <p class="text-sm text-gray-500">{{ $achievement->category }} - {{ $achievement->event_date ? \Carbon\Carbon::parse($achievement->event_date)->format('d M Y') : 'No date' }}</p>
                        
                        @if($achievement->items->count() > 0)
                            <div class="mt-2 pl-4 border-l-2 border-neutral-200 dark:border-neutral-700">
                                @foreach($achievement->items->take(3) as $item)
                                    <p class="text-sm">{{ $item->achievement }} ({{ $item->student_count }} students)</p>
                                @endforeach
                                @if($achievement->items->count() > 3)
                                    <p class="text-xs text-gray-500 mt-1">+ {{ $achievement->items->count() - 3 }} more achievements</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
