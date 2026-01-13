<!DOCTYPE html>


<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir={{ \App\Models\Language::getDefaultDirection() }}
    class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <flux:sidebar sticky stashable
            class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 w-64 flex flex-col">
            <div class="flex items-center justify-between px-4 py-3">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                    <x-app-logo />
                </a>
                <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
            </div>

            <flux:navlist variant="outline" class="px-2">
                <flux:navlist.group :heading="__('Platform')" class="space-y-1">
                    <flux:navlist.item icon="home" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('My Wallet') }}
                    </flux:navlist.item>


                </flux:navlist.group>

                @hasrole('user')
                    <flux:navlist.group :heading="__('Investment')" class="space-y-1">

                        <flux:navlist.item icon="circle-dollar-sign" :href="route('users.plans.index')"
                            :current="request()->routeIs('users.plans.index')" wire:navigate>
                            {{ __('View Plans') }}
                        </flux:navlist.item>

                        <flux:navlist.item icon="circle-dollar-sign" :href="route('users.investments.index')"
                            :current="request()->routeIs('users.investments.index')" wire:navigate>
                            {{ __('My Investments') }}
                        </flux:navlist.item>


                        <flux:navlist.item icon="history" :href="route('profit-withdrawals.index')" wire:navigate
                            :current="request()->routeIs('profit-withdrawals.index')">
                            {{ __('Profit  History') }}
                        </flux:navlist.item>

                        <flux:navlist.item icon="history" :href="route('affiliate.index')" wire:navigate
                            :current="request()->routeIs('affiliate.index')">
                            {{ __('Affiliate  History') }}
                        </flux:navlist.item>



                    </flux:navlist.group>
                @endhasrole
                <flux:navlist.group :heading="__('Wallet Management')" class="mt-3 space-y-1">
                    <flux:navlist.group expandable :expanded="false" heading="{{ __('Wallet') }}">
                        <flux:navlist.item :href="route('transactions.index')"
                            :current="request()->routeIs('transactions.index')" wire:navigate>
                            {{ __('All Transactions') }}
                        </flux:navlist.item>

                        @hasrole('super admin')
                            <flux:navlist.item :href="route('wallet-requests.index')"
                                :current="request()->routeIs('wallet-requests.index')" wire:navigate>
                                {{ __('Wallet Deposit Requests') }}
                            </flux:navlist.item>
                            <flux:navlist.item :href="route('withdraw-requests.index')"
                                :current="request()->routeIs('withdraw-requests.index')" wire:navigate>
                                {{ __('Withdraw Requests') }}
                            </flux:navlist.item>
                            <flux:navlist.item :href="route('crypto-wallet.index')"
                                :current="request()->routeIs('crypto-wallet.index')" wire:navigate>
                                {{ __('Crypto Wallet') }}
                            </flux:navlist.item>
                        @endhasrole
                        {{-- <flux:navlist.item :href="route('users.create')"
                            :current="request()->routeIs('users.create')" wire:navigate>
                            {{ __('Create New User') }}
                        </flux:navlist.item> --}}

                    </flux:navlist.group>
                </flux:navlist.group>

                @can('view users')
                    <flux:navlist.group :heading="__('Users Management')" class="mt-3 space-y-1">
                        <flux:navlist.group expandable :expanded="false" heading="{{ __('Users') }}">
                            <flux:navlist.item :href="route('users.index')" :current="request()->routeIs('users.index')"
                                wire:navigate>
                                {{ __('All Users') }}
                            </flux:navlist.item>
                            @can('create user')
                                <flux:navlist.item :href="route('users.create')" :current="request()->routeIs('users.create')"
                                    wire:navigate>
                                    {{ __('Create New User') }}
                                </flux:navlist.item>
                            @endcan
                        </flux:navlist.group>
                    </flux:navlist.group>
                @endcan

                @if (auth()->user()->can('view roles') || auth()->user()->can('view permissions'))
                    <flux:navlist.group :heading="__('Roles & Permissions')" class="mt-3 space-y-1">
                        <flux:navlist.group expandable :expanded="false" heading="{{ __('Roles') }}">
                            <flux:navlist.item :href="route('roles.index')"
                                :current="request()->routeIs('roles.index')" wire:navigate>
                                {{ __('All Roles') }}
                            </flux:navlist.item>
                            @can('create role')
                                <flux:navlist.item :href="route('roles.create')"
                                    :current="request()->routeIs('roles.create')" wire:navigate>
                                    {{ __('Create New Role') }}
                                </flux:navlist.item>
                            @endcan
                        </flux:navlist.group>

                        <flux:navlist.group expandable :expanded="false" heading="{{ __('Permissions') }}">
                            <flux:navlist.item :href="route('permissions.index')"
                                :current="request()->routeIs('permissions.index')" wire:navigate>
                                {{ __('All Permissions') }}
                            </flux:navlist.item>
                            @can('create permission')
                                <flux:navlist.item :href="route('permissions.create')"
                                    :current="request()->routeIs('permissions.create')" wire:navigate>
                                    {{ __('Create New Permission') }}
                                </flux:navlist.item>
                            @endcan
                        </flux:navlist.group>
                    </flux:navlist.group>
                @endif

                @if (auth()->user()->can('view languages') || auth()->user()->can('view translations'))
                    <flux:navlist.group :heading="__('Languages & Translations')" class="mt-3 space-y-1">
                        <flux:navlist variant="outline">
                            <flux:navlist.item icon="languages" :href="route('languages.index')" wire:navigate
                                :current="request()->routeIs('languages.index')">
                                {{ __('Languages') }}
                            </flux:navlist.item>


                        </flux:navlist>


                    </flux:navlist.group>
                @endif



                @hasrole('super admin')
                    <flux:navlist.group :heading="__('Plans and Members Management')" class="mt-3 space-y-1">
                        <flux:navlist variant="outline">
                            <flux:navlist.item icon="square-chart-gantt" :href="route('plans.index')" wire:navigate
                                :current="request()->routeIs('plans.index')">
                                {{ __('All Plans') }}
                            </flux:navlist.item>

                            <flux:navlist.item icon="users" :href="route('members.index')" wire:navigate
                                :current="request()->routeIs('members.index')">
                                {{ __('All Members') }}
                            </flux:navlist.item>

                            <flux:navlist.item icon="history" :href="route('profit-withdrawals.index')" wire:navigate
                                :current="request()->routeIs('profit-withdrawals.index')">
                                {{ __('Profit  History') }}
                            </flux:navlist.item>


                       <flux:navlist.item icon="history" :href="route('affiliate.index')" wire:navigate
                        :current="request()->routeIs('affiliate.index')">
                        {{ __('Affiliate  History') }}
                       </flux:navlist.item>


                        </flux:navlist>


                    </flux:navlist.group>
                @endhasrole

            </flux:navlist>

            <flux:spacer />
            @can('view activity logs')
                <flux:navlist variant="outline">
                    <flux:navlist.item icon="folder-git-2" :href="route('activity-logs.index')" wire:navigate
                        :current="request()->routeIs('activity-logs.index')">
                        {{ __('Activity Logs') }}
                    </flux:navlist.item>


                </flux:navlist>
            @endcan

            <!-- User dropdown (desktop) -->

            <!--
                <flux:dropdown class="hidden lg:block px-4 pb-4" position="top" align="start">
                    <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()" />
                    <flux:menu class="w-56">
                        <flux:menu.radio.group>
                            <div class="flex items-center gap-2 px-2 py-2">
                                <span
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 dark:bg-neutral-700">
                                    {{ auth()->user()->initials() }}
                                </span>
                                <div class="flex-1 text-sm">
                                    <span class="block font-semibold truncate">{{ auth()->user()->name }}</span>
                                    <span class="block text-xs truncate text-zinc-500 dark:text-zinc-400">
                                        {{ auth()->user()->email }}
                                    </span>
                                </div>
                            </div>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
                -->
        </flux:sidebar>

        <!-- Main section -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Header -->
            <flux:header
                class="sticky top-0 z-10 flex items-center justify-between md:justify-end border-b border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-700 dark:bg-zinc-900">
                <!-- Mobile menu button -->
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />




                <!-- Notifications + user -->
                <div class="flex items-center gap-4">
                    <flux:modal.trigger name="notifications">
                        <button
                            class=" relative flex items-center gap-2 text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 px-2">

                            <flux:icon name="bell" badge="12" />
                            <div
                                class="absolute inline-flex items-center justify-center w-3 h-3 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-0 dark:border-gray-900">
                            </div>
                        </button>



                        </button>
                    </flux:modal.trigger>

                    <flux:modal name="notifications" variant="flyout">
                        {{-- notifications header --}}
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">{{ __('Notifications') }}</flux:heading>
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ __('Recent notifications and alerts') }}
                                </p>
                            </div>
                            <flux:separator />

                            {{-- single notification --}}
                            <div
                                class="flex items-center gap-4  bg-white p-4  dark:border-zinc-700 dark:bg-zinc-800 max-w-sm">
                                <!-- أيقونة الإشعار -->

                                <!-- نصوص الإشعار -->
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        New user registered
                                    </p>

                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                        John Doe has just signed up.
                                    </p>
                                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-200">
                                        5 minutes ago
                                    </p>
                                </div>
                                <flux:button icon="x-mark" size="xs" variant="subtle" />

                            </div>

                    </flux:modal>

                    <flux:dropdown position="bottom" align="end" class="lg:hidden">
                        <flux:profile :initials="auth()->user()->initials()" />
                        <flux:menu>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                                {{ __('Settings') }}
                            </flux:menu.item>
                            <flux:menu.separator />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </div>


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
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>

            </flux:header>

            <!-- Content area -->
            <main class="flex-1 overflow-y-auto bg-zinc-50  dark:bg-zinc-800">
                <div class="mx-auto max-w-7xl mb-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @fluxScripts

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/695ced27607b2b197dd88525/1je9fsp1j';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>
