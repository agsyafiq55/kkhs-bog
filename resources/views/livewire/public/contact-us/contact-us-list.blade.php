<div>
    <!-- Page Hero Section -->
    <div class="bg-black relative overflow-hidden p-0 m-0 shadow-md -mx-6 -mt-6 lg:-mx-8 lg:-mt-8">
        <!-- Background image with overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.pexels.com/photos/7651924/pexels-photo-7651924.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Newspaper"
                alt="Events background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-zinc-900/80"></div>
        </div>
        <div class="relative z-10 flex flex-col items-center text-center py-16 px-4">
            <!-- Main heading -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-2">Get in touch.</h1>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold text-red-800 mb-6">公告</h2>

            <!-- Subtitle -->
            <p class="text-gray-300 max-w-2xl mb-2">
                Reach out to us with any questions or inquiries.<br>如有任何问题或疑问，请联系我们。
            </p>
        </div>
    </div>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    @if ($contactUs)
        <div class="mt-12 grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div
                class="space-y-6 bg-white dark:bg-zinc-900 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-800">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Address</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $contactUs->address }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Email</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                        <a href="mailto:{{ $contactUs->email }}"
                            class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            {{ $contactUs->email }}
                        </a>
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Phone Numbers</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                        <a href="tel:{{ $contactUs->phone_no1 }}"
                            class="block text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            {{ $contactUs->phone_no1 }}
                        </a>
                        @if ($contactUs->phone_no2)
                            <a href="tel:{{ $contactUs->phone_no2 }}"
                                class="block text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                {{ $contactUs->phone_no2 }}
                            </a>
                        @endif
                    </p>
                </div>
            </div>

            <div
                class="h-96 bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-800">
                @if ($contactUs->map_url)
                    <iframe src="{{ $contactUs->map_url }}" class="w-full h-full rounded-xl" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @endif
            </div>
        </div>
    @else
        <div class="mt-12 text-center text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-zinc-800 p-8 rounded-lg">
            Contact information is not available at the moment.
        </div>
    @endif
</div>
</div>