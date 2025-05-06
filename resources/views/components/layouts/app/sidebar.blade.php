<!--THIS IS THE SIDEBAR USED FOR ADMIN SIDE-->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <div class="flex min-h-screen">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-900 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>
            <!-- NAVIGATION LINKS -->
            <flux:navlist variant="outline">
                    <flux:navlist.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:navlist.item>
                    <flux:navlist.group class="grid">
                        <flux:navlist.item :href="route('admin.events')" :current="request()->routeIs('admin.events')" wire:navigate>
                            {{ __('Events') }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('admin.gallery')" :current="request()->routeIs('admin.gallery')" wire:navigate>
                            {{ __('Gallery') }}
                        </flux:navlist.item>
                        
                        <flux:navlist.item :href="route('admin.announcements')" :current="request()->routeIs('admin.announcements*')" wire:navigate>
                            {{ __('Announcements') }}
                        </flux:navlist.item>

                        <flux:navlist.item :href="route('admin.contactus.display')" :current="request()->routeIs('admin.contactus*')" wire:navigate>
                            {{ __('Contact Details') }}
                        </flux:navlist.item>
                        
                        <flux:navlist.group expandable :expanded="request()->routeIs('admin.aboutus*') || request()->routeIs('admin.timeline')" heading="About Us" class="hidden lg:grid">
                            <flux:navlist.item  :href="route('admin.aboutus')" :current="request()->routeIs('admin.aboutus')" wire:navigate>
                            {{ __('Organization Info') }}
                            </flux:navlist.item>
                            <flux:navlist.item 
                                :href="route('admin.aboutus.members.list')"
                                :current="request()->routeIs('admin.aboutus.members.*')"
                                wire:navigate>
                                {{ __('Members') }}
                            </flux:navlist.item>
                            <flux:navlist.item 
                                :href="route('admin.timeline')"
                                :current="request()->routeIs('admin.timeline')"
                                wire:navigate>
                                {{ __('Our History') }}
                            </flux:navlist.item>
                        </flux:navlist.group>
                        
                        <flux:navlist.group expandable :expanded="request()->routeIs('admin.achievements.*')" heading="Achievements" class="hidden lg:grid">
                            <flux:navlist.item 
                                :href="route('admin.achievements.academic.index')" 
                                :current="request()->routeIs('admin.achievements.academic.*')" 
                                wire:navigate>
                                {{ __('Academic') }}
                            </flux:navlist.item>
                            <flux:navlist.item 
                                :href="route('admin.achievements.cocurricular.index')" 
                                :current="request()->routeIs('admin.achievements.cocurricular.*')" 
                                wire:navigate>
                                {{ __('Co-Curricular') }}
                            </flux:navlist.item>
                        </flux:navlist.group>
                        
                    </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down" />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('register')" icon="user-plus" wire:navigate>{{ __('Register New Admin') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <div class="flex-1 flex flex-col">
            <!-- Mobile User Menu -->
            <flux:header class="lg:hidden">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

                <flux:spacer />

                <flux:dropdown position="top" align="end">
                    <flux:profile
                        :initials="auth()->user()->initials()"
                        icon-trailing="chevron-down" />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:header>

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>

    @fluxScripts
</body>

</html>