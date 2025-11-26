<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid  gap-2">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}
                </flux:navlist.item>
            </flux:navlist.group>


            @can('view users')
                <flux:navlist.group :heading="__('Users Management')" class=" mt-2 grid  gap-2"> </flux:navlist.group>
                <flux:navlist.group expandable :expanded="false" heading="{{ __('Users') }}" class="lg:grid">

                    <flux:navlist.item icon="" :href="route('users.index')"
                        :current="request()->routeIs('users.index')" wire:navigate>{{ __('All Users') }}
                    </flux:navlist.item>
                    @can('create user')
                        <flux:navlist.item icon="" :href="route('users.create')"
                            :current="request()->routeIs('users.create')" wire:navigate>{{ __('Create New User') }}
                        </flux:navlist.item>
                    @endcan

                </flux:navlist.group>
            @endcan

            @if (auth()->user()->can('view roles') || auth()->user()->can('view permissions'))
                <flux:navlist.group :heading="__('Roles & Permissions')" class=" mt-2 grid  gap-2">
                </flux:navlist.group>

                <flux:navlist.group expandable :expanded="false" heading="{{ __('Roles') }}" class="lg:grid">

                    <flux:navlist.item icon="" :href="route('roles.index')"
                        :current="request()->routeIs('roles.index')" wire:navigate>{{ __('All Roles') }}
                    </flux:navlist.item>
                    @can('create role')
                        <flux:navlist.item icon="" :href="route('roles.create')"
                            :current="request()->routeIs('roles.create')" wire:navigate>{{ __('Create New Role') }}
                        </flux:navlist.item>
                    @endcan



                </flux:navlist.group>



                <flux:navlist.group expandable :expanded="false" heading="{{ __('Permissions') }}"
                    class="lg:grid">

                    <flux:navlist.item icon="" :href="route('permissions.index')"
                        :current="request()->routeIs('permissions.index')" wire:navigate>{{ __('All Permissions') }}
                    </flux:navlist.item>

                    @can('create permission')
                        <flux:navlist.item icon="" :href="route('permissions.create')"
                            :current="request()->routeIs('permissions.create')" wire:navigate>
                            {{ __('Create New Permission') }}
                        </flux:navlist.item>
                    @endcan
                </flux:navlist.group>
            @endif


        </flux:navlist>


        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" :href="route('activity-logs.index')" wire:navigate
                :current="request()->routeIs('activity-logs.index')">
                {{ __('Activity Logs') }}
            </flux:navlist.item>

            {{-- <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item> --}}
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
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

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
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

    {{ $slot }}

    @fluxScripts
</body>

</html>
