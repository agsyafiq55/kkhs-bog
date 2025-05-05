<div class="container mx-auto py-8">
    <div class="relative">
        <!-- Timeline Line -->
        <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-px bg-indigo-400/30"></div>

        <div class="relative">
            @foreach ($timelineCards as $index => $card)
                <div class="mb-16 relative">
                    <!-- Timeline Node -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 -mt-1">
                        <div class="w-4 h-4 bg-indigo-600 rounded-full shadow-lg shadow-indigo-400/50"></div>
                    </div>

                    <div class="flex items-center justify-center">
                        <!-- Content -->
                        <div class="w-5/12 {{ $index % 2 == 0 ? 'mr-auto' : 'ml-auto' }}">
                            <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl shadow-lg border border-white/10 hover:shadow-xl transition-all duration-300">
                                <div class="flex items-center mb-4">
                                    <div class="bg-indigo-600/20 rounded-lg px-3 py-1">
                                        <span class="text-4xl font-bold text-indigo-400">{{ $card->year }}</span>
                                    </div>
                                </div>
                                <h4 class="text-lg font-semibold text-white mb-3">{{ $card->title }}</h4>
                                @if ($card->description)
                                    <p class="text-gray-300 mb-2">{{ $card->description }}</p>
                                @endif
                                @if ($card->description_zh)
                                    <p class="text-gray-300 font-chinese">{{ $card->description_zh }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
