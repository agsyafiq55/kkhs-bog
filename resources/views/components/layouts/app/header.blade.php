<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-900 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="/" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0">
            <x-app-logo />
        </a>
        <!-- LINKS FOR DESKTOP -->
        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item icon="users" href="{{ route('aboutus') }}" :current="request()->is('about-us')">
                {{ __('About Us') }}
            </flux:navbar.item>
            <flux:navbar.item icon="calendar" href="{{ route('events.index') }}" :current="request()->is('events')">
                {{ __('Events') }}
            </flux:navbar.item>
            <flux:navbar.item icon="photo" href="{{ route('gallery') }}" :current="request()->is('gallery')">
                {{ __('Gallery') }}
            </flux:navbar.item>
            <flux:navbar.item icon="megaphone" href="{{ route('announcements.index') }}" :current="request()->is('announcements*')">
                {{ __('Announcements') }}
            </flux:navbar.item>
            <flux:navbar.item icon="phone" href="{{ route('contact-us') }}" :current="request()->is('contact-us')">
                {{ __('Contact Us') }}
            </flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        <flux:navbar class="mr-1.5 space-x-0.5 py-0!">
            {{-- Language Picker --}}
            <flux:tooltip content="Choose Language">
                <div class="gtranslate_wrapper"></div>
                <script>window.gtranslateSettings = {"default_language":"en","detect_browser_language":true,"languages":["en","zh-CN"],"wrapper_selector":".gtranslate_wrapper"}</script>
                <script src="https://cdn.gtranslate.net/widgets/latest/flags.js" defer></script>
            </flux:tooltip>

            {{-- Dark Mode Toggle --}}
            <flux:tooltip content="Toggle Dark Mode">
                <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode"/>
            </flux:tooltip>
           
            <flux:navbar.item href="{{ route('login') }}" :current="request()->is('loginS')">
                {{ __('Login') }}
            </flux:navbar.item>
        </flux:navbar>
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky class="lg:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('home') }}" class="ml-1 flex items-center space-x-2" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')">
                <!-- Links for mobile -->
                <flux:navlist.item icon="layout-grid" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                    {{ __('Home') }}
                </flux:navlist.item>
                <flux:navlist.item icon="calendar" :href="route('events.index')" :current="request()->is('events')">
                    {{ __('Events') }}
                </flux:navlist.item>
                <flux:navlist.item icon="photo" :href="route('gallery')" :current="request()->is('gallery')">
                    {{ __('Gallery') }}
                </flux:navlist.item>
                <flux:navlist.item icon="megaphone" :href="route('announcements.index')" :current="request()->is('announcements*')">
                    {{ __('Announcements') }}
                </flux:navlist.item>
                <flux:navlist.item icon="users" :href="route('aboutus')" :current="request()->is('about-us')">
                    {{ __('About Us') }}
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

    </flux:sidebar>

    {{ $slot }}

    @fluxScripts
</body>

</html>
