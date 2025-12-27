<div class="min-h-screen bg-white dark:bg-zinc-900 p-4 font-[Tajawal]">
    <!-- Header -->
    <div
        class="flex items-center justify-between mb-8 bg-zinc-50 dark:bg-zinc-800 p-4 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
        <button onclick="history.back()"
            class="p-2 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-full transition-colors">
            <flux:icon.chevron-left class="size-6 text-zinc-800 dark:text-white" />
        </button>
        <h1 class="text-xl font-bold flex-1 text-center text-zinc-900 dark:text-white">حدد عملة إعادة الشحن</h1>
        <div class="w-10"></div> <!-- Spacer for centering -->
    </div>

    <!-- Wallets List Container -->
    <div class="space-y-4">
        @forelse ($wallets as $wallet)
            <a href="{{ route('deposit-page.details', $wallet->id) }}" class="block">
                <div class="flex items-center justify-between p-5 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-300 group"
                    wire:key="{{ $wallet->id }}">
                    <div class="flex items-center gap-4">
                        <!-- Icon Placeholder -->
                        <div
                            class="size-12 rounded-full bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            @php
                                $iconName = match (strtolower($wallet->name)) {
                                    'trx' => 'currency-dollar',
                                    'bnb' => 'variable',
                                    'polygon' => 'hexagon',
                                    'eth' => 'code-bracket',
                                    default => 'credit-card'
                                };
                            @endphp
                            <flux:icon.{{ $iconName }} variant="outline" class="size-6 text-zinc-600 dark:text-zinc-300" />
                        </div>

                        <div class="flex flex-col">
                            <span
                                class="text-lg font-bold tracking-wide uppercase text-zinc-900 dark:text-white">{{ $wallet->name }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <flux:icon.chevron-right
                            class="size-5 text-zinc-400 dark:text-zinc-500 group-hover:translate-x-1 group-hover:text-zinc-800 dark:group-hover:text-white transition-all" />
                    </div>
                </div>
            </a>
        @empty
            <div
                class="p-10 text-center text-zinc-500 dark:text-zinc-400 italic bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                لا يوجد محافظ بحالات نشطة حالياً
            </div>
        @endforelse
    </div>
</div>