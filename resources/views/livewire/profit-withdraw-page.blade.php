<div x-data="{
    network: @entangle('network'),
    wallet_address: @entangle('wallet_address'),
    password: @entangle('password')
}" class="min-h-screen bg-white dark:bg-zinc-900 p-4 font-[Tajawal]">
    <!-- Header -->
    <div
        class="flex items-center justify-between mb-8 bg-zinc-50 dark:bg-zinc-800 p-4 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
        <button onclick="history.back()"
            class="p-2 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-full transition-colors">
            <flux:icon.chevron-left class="size-6 text-zinc-800 dark:text-white" />
        </button>
        <h1 class="text-xl font-bold flex-1 text-center text-zinc-900 dark:text-white">سحب الأرباح</h1>
        <div class="w-10"></div>
    </div>

    <!-- Main Card -->
    <div class="max-w-xl mx-auto space-y-6">
        <!-- Amount Display (Fixed) -->
        <div class="bg-zinc-900 text-white rounded-xl p-6 relative overflow-hidden shadow-lg border border-zinc-700">
            <div class="relative z-10">
                <div class="text-sm text-zinc-400 mb-1">مبلغ السحب المحدد</div>

                <div class="text-3xl font-bold mt-1 tracking-wider">{{ number_format($amount, 2) }}
                    <span class="text-sm font-normal">USDT</span>
                </div>
            </div>
            <!-- Decorative logo or icon -->
            <div class="absolute top-4 left-4 opacity-20">
                <flux:icon.currency-dollar class="size-16" />
            </div>
        </div>

        <!-- Network Selection -->
        <div class="space-y-3">
            <div class="text-sm text-zinc-500 dark:text-zinc-400">طريقة السحب</div>

            <!-- Alpine.js handled selection -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach ($networks as $net)
                    <button @click="network = '{{ $net }}'" type="button"
                        class="flex items-center justify-center gap-2 p-3 rounded-lg border transition-all"
                        :class="network === '{{ $net }}' ?
                                                'bg-blue-600 border-blue-600 text-white shadow-md transform scale-[1.02]' :
                                                'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:border-zinc-400 dark:hover:border-zinc-500'">
                        <span class="text-xs font-bold uppercase">{{ $net }}</span>
                    </button>
                @endforeach
            </div>
            @error('network')
                <span class="text-red-500 text-xs px-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Form Fields -->
        <div class="space-y-4">

            <!-- Wallet Address -->
            <flux:input x-model="wallet_address" name="wallet_address" label="عنوان السحب"
                placeholder="أدخل عنوان المحفظة" />

            <!-- Password -->
            <flux:input x-model="password" name="password" label="كلمة المرور" type="password"
                placeholder="أدخل كلمة المرور" />

            <!-- Summary -->
            <div class="flex justify-between items-center text-xs text-zinc-500 dark:text-zinc-400 px-1">
                <span>مصاريف (1%)</span>
                <span>{{ number_format($amount * 0.01, 2) }} USDT</span>
            </div>
            <div class="flex justify-between items-center text-xs text-zinc-500 dark:text-zinc-400 px-1">
                <span>تلقى فعلا</span>
                <span class="font-bold text-zinc-800 dark:text-white">
                    {{ number_format($amount * 0.99, 2) }} USDT
                </span>
            </div>

            <!-- Submit -->
            <flux:button wire:click="withdraw" variant="primary"
                class="w-full h-12 text-lg font-bold shadow-lg shadow-blue-500/20">
                تأكيد السحب
            </flux:button>
        </div>

        <!-- Note -->
        <div
            class="p-4 mb-8 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 text-center text-sm text-zinc-500 dark:text-zinc-400">
            وقت السحب حوالي 0~30 دقيقة
        </div>
    </div>
</div>