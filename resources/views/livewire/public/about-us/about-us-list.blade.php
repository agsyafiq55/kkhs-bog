<div>
    <div
        class="relative overflow-hidden rounded-2xl shadow-lg border border-gray-200 dark:border-zinc-800 max-w-6xl mx-auto mb-12">
        <img src="https://mrwallpaper.com/images/hd/chinese-lantern-photography-azuq3mbutdxhp3z7.jpg"
            alt="Chinese lantern" class="absolute inset-0 w-full h-full object-cover z-0">
        <div class="absolute inset-0   bg-zinc-700/50 dark:bg-black/50 z-10"></div>

        <div class="relative z-20 flex flex-col md:flex-row items-center md:items-start p-10 md:p-16">
            <div class="md:w-2/3 mb-6 md:mb-0">
                <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-white mb-3">About
                    Us</h1>
                <div class="mt-6">
                    <!-- Year Filter Dropdown -->
                    <div class="flex items-center space-x-2 mb-4">
                        <label for="yearFilter" class="text-sm font-medium text-gray-300">Choose
                            Year:</label>
                        <div class="relative">
                            <div
                                class="absolute -inset-[2px] bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-lg">
                            </div>
                            <flux:select id="yearFilter" wire:model.live="selectedYear"
                                class="relative w-32">
                                @foreach ($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- About us section --}}
    <div class="container mx-auto max-w-6xl">
        @if ($aboutUs)
        <div class="space-y-6">
            <div class="mb-4">
                <h2 class="text-3xl md:text-4xl font-bold text-zinc-900/80 dark:text-white">We are KKHS Board of Governors</h2>
            </div>
            <!-- Organization Photo -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-zinc-900">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="md:w-2/3">
                        <div class="h-full">
                            <img src="{{ asset('storage/' . $aboutUs->organization_photo) }}"
                                alt="Organization Photo" class="w-full h-full object-cover rounded-sm">
                        </div>
                    </div>
                    <div class="md:w-1/3 flex flex-col justify-center">
                        <p class="text-sm md:text-base text-justify text-gray-700 dark:text-gray-300">
                            {{ 'Our esteemed Board of Governors stands as a testament to the rich tapestry of our community, drawing together accomplished individuals from a wide spectrum of professional backgrounds and industries. United by a shared vision for excellence, this dedicated body is deeply committed to the ongoing maintenance and strategic development of our school. Their collective expertise and varied perspectives serve as invaluable assets, enriching our institutions governance and ensuring a holistic approach to progress. More importantly, the Boards unwavering focus remains on fostering an environment that nurtures the comprehensive development and overall well-being of each and every student under our care, striving to empower them to reach their full potential.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Chairman Photo and Speech Combined -->
            <div class="mb-4">
                <h2 class="text-3xl md:text-4xl font-bold text-zinc-900/80 dark:text-white">Chairman's Speech</h2>
            </div>
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-zinc-900">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="md:w-1/3 flex flex-col items-center">
                        <div class="w-64 h-64 mb-4 overflow-hidden rounded-lg shadow-md">
                            <img src="{{ asset('storage/' . $aboutUs->chairman_photo) }}" alt="Chairman Photo"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ optional($chairman)->member_name ?? '—' }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $selectedYear }} Chairman</p>
                        </div>
                    </div>
                    <div class="md:w-2/3">
                        <div class="prose max-w-none">
                            <p class="whitespace-pre-line text-gray-700 dark:text-gray-300 text-justify">
                                {!! $aboutUs->chairman_speech !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Board Members Section -->
            <div
                class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-gray-100 dark:border-zinc-700 relative overflow-hidden">
                <!-- Background banner with overlay -->
                <div class="relative overflow-hidden mb-8">
                    <div class="absolute inset-0 z-0">
                        <img src="https://images.pexels.com/photos/6775105/pexels-photo-6775105.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            alt="Chinese landscape" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-zinc-700/40 dark:bg-black/50"></div>
                    </div>

                    <div class="flex flex-col md:flex-row relative z-10 p-4 sm:p-8">
                        <div class="w-full md:w-2/3 flex flex-col justify-center space-y-2 md:space-y-4">
                            <h1 class="text-white text-4xl sm:text-4xl md:text-6xl font-bold">Meet Our Team</h1>
                            <p class="text-gray-300 text-sm md:text-base text-justify">
                                Meet our dedicated team of Board of Governors who are committed to the growth and
                                development of our school.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Members Grid -->
                <div class="p-6">
                    @php
                    $positionColors = [
                    'Chairman' => 'red',
                    'Vice Chairman I' => 'indigo',
                    'Vice Chairman II' => 'blue',
                    'Secretary' => 'emerald',
                    'Treasurer' => 'amber',
                    'Supervision' => 'orange',
                    'Member of Board of Governor' => 'violet',
                    ];

                    // Sort members by position importance
                    $sortOrder = [
                    'Chairman' => 1,
                    'Vice Chairman I' => 2,
                    'Vice Chairman II' => 3,
                    'Secretary' => 4,
                    'Treasurer' => 5,
                    'Supervision' => 6,
                    'Member of Board of Governor' => 7,
                    ];

                    $sortedMembers = $members->sortBy(function ($member) use ($sortOrder) {
                    return $sortOrder[$member->position] ?? 999;
                    });
                    @endphp

                    @if (count($members) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($sortedMembers as $member)
                        <!-- Member card code remains the same -->
                        <div
                            class="group relative bg-white dark:bg-zinc-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100 dark:border-zinc-700">
                            <div class="p-6">
                                <!-- Member Photo - Centered and Rounded -->
                                <div class="flex justify-center mb-4">
                                    <div
                                        class="relative w-[150px] h-[150px] rounded-full overflow-hidden bg-gray-100 dark:bg-zinc-800 border-4 border-white dark:border-zinc-700 shadow-md">
                                        <img src="{{ asset('storage/' . $member->photo) }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            alt="{{ $member->member_name }}">
                                    </div>
                                </div>

                                <!-- Member Content -->
                                <div class="text-center">
                                    <h3
                                        class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                                        {{ $member->member_name }}
                                    </h3>

                                    <flux:badge color="{{ $positionColors[$member->position] ?? 'zinc' }}"
                                        class="text-sm">
                                        {{ $member->position === 'Member of Board of Governor' ? 'Member' : $member->position }}
                                    </flux:badge>
                                    @if ($member->zh_member_name)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        {{ $member->zh_member_name }}
                                    </p>
                                    @endif
                                    @if ($member->zh_position)
                                    <p class="text-xs text-gray-500 dark:text-gray-500">
                                        {{ $member->zh_position }}
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Hover overlay for better UX -->
                            <div
                                class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity pointer-events-none">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12 bg-gray-50 dark:bg-zinc-900 rounded-lg">
                        <p class="text-gray-500 dark:text-gray-400">No board members available.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Timeline Section -->
            <div
                class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700 relative overflow-hidden">
                <!-- Background banner with overlay -->
                <div class="relative overflow-hidden mb-8">
                    <div class="absolute inset-0 z-0">
                        <img src="https://cdn.pixabay.com/photo/2017/07/02/09/03/books-2463779_1280.jpg"
                            alt="Books" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-zinc-700/40 dark:bg-black/50"></div>
                    </div>

                    <div class="flex flex-col md:flex-row relative z-10 p-4 sm:p-8">
                        <div class="w-full md:w-2/3 flex flex-col justify-center space-y-2 md:space-y-4">
                            <h1 class="text-white text-4xl sm:text-4xl md:text-7xl font-bold">Our Journey</h1>
                            <p class="text-gray-300 text-sm md:text-base text-justify">
                                The journey of KKHS Board of Governors from its establishment to the present day.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Timeline Component -->
                <div class="p-6">
                    <livewire:timeline />
                </div>
            </div>
        </div>
        @else
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm p-12 border border-gray-100 dark:border-zinc-700 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-6">No information available yet.</p>
        </div>
        @endif
    </div>
</div>