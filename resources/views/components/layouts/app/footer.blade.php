<footer class="bg-white dark:bg-zinc-900 mt-8">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="/" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0">
                    <x-app-logo />
                </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2">
                {{-- Links --}}
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Links</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="https://kkhs.edu.my/pibg-pta-%e5%ba%87%e4%b8%ad%e5%ae%b6%e6%95%99%e5%8d%8f%e4%bc%9a/"
                                class="hover:underline">KKHS PIBG</a>
                        </li>
                        <li>
                            <a href="http://www.kkhs.org.my/exstudent/" class="hover:underline">KKHS Ex-Students
                                Assoc</a>
                        </li>
                    </ul>
                </div>
                {{-- Follow Us --}}
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Follow us</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="https://www.youtube.com/c/KotaKinabaluHighSchool"
                                class="hover:underline ">YouTube</a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/KotaKinabaluHighSchool/?locale=ms_MY"
                                class="hover:underline">Facebook</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a href="/"
                    class="hover:underline">KKHS Board of Governors</a>. All Rights Reserved.
            </span>
            <div class="flex mt-4 sm:justify-center sm:mt-0">
                <flux:navbar.item href="{{ route('login') }}" :current="request()->is('loginS')">
                    {{ __('Admin Login') }}
                </flux:navbar.item>
            </div>
        </div>
    </div>
</footer>
