@php
    $active = 'text-primary scale-110';
    $inactive = 'text-zinc-500 dark:text-zinc-400';
@endphp

<nav
    class="fixed bottom-0 left-0 right-0 z-50
           bg-white/90 dark:bg-zinc-900/90
           backdrop-blur
           border-t border-zinc-200 dark:border-zinc-700
           md:hidden">

    <div class="flex justify-around items-center h-16">

        <!-- Dashboard -->
        <a href="https://tkwencash.com"
            class="group flex flex-col items-center text-xs transition-all duration-300
         {{ request()->routeIs('plans.index') ? $active : $inactive }}"">

            <flux:icon name="home"
                class="w-6 h-6 transition-transform duration-300
                group-hover:-translate-y-1" />

            <span class="mt-1">
                {{ __('الصفحة الرئيسة') }}
            </span>
        </a>

        <!-- Investment -->
        <a href="{{ route('plans.index') }}"
            class="group flex flex-col items-center text-xs transition-all duration-300
           {{ request()->routeIs('plans.index') ? $active : $inactive }}">

            <flux:icon name="chart-bar"
                class="w-6 h-6 transition-transform duration-300
                group-hover:-translate-y-1" />

            <span class="mt-1">
                {{ __('الخطط') }}
            </span>
        </a>

        <!-- Wallet -->
        <a href="{{ route('dashboard') }}"
            class="group flex flex-col items-center text-xs transition-all duration-300
           {{ request()->routeIs('dashboard') ? $active : $inactive }}">

            <flux:icon name="wallet"
                class="w-6 h-6 transition-transform duration-300
                group-hover:-translate-y-1" />

            <span class="mt-1">
                {{ __('Wallet') }}
            </span>
        </a>

        <!-- Settings -->
        <a href="{{ route('users.investments.index') }}"
            class="group flex flex-col items-center text-xs transition-all duration-300
           {{ request()->routeIs('users.investments.index') ? $active : $inactive }}">

            <flux:icon name="cog-6-tooth"
                class="w-6 h-6 transition-transform duration-300
                group-hover:-translate-y-1" />

            <span class="mt-1">
                {{ __('My Investments') }}
            </span>
        </a>

    </div>
</nav>
