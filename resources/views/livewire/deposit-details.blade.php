<div class="min-h-screen bg-white dark:bg-zinc-900 p-4 font-[Tajawal]">
    <!-- Header -->
    <div
        class="flex items-center justify-between mb-8 bg-zinc-50 dark:bg-zinc-800 p-4 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
        <button onclick="history.back()"
            class="p-2 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-full transition-colors">
            <flux:icon.chevron-left class="size-6 text-zinc-800 dark:text-white" />
        </button>
        <h1 class="text-xl font-bold flex-1 text-center text-zinc-900 dark:text-white">تعبئة رصيد</h1>
        <div class="w-10"></div>
    </div>

    <!-- Details Card -->
    <div
        class="max-w-md mx-auto bg-zinc-50 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 shadow-lg text-center">
        <!-- Coin Icon/Name -->
        <div class="flex items-center justify-center gap-2 mb-6">
            <div class="size-8 rounded-full bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center">
                {{-- Use the same icon logic or pass it --}}
                @php
                    $iconName = match (strtolower($wallet->name)) {
                        'trx' => 'currency-dollar',
                        'bnb' => 'variable',
                        'polygon' => 'hexagon',
                        'eth' => 'code-bracket',
                        default => 'credit-card'
                    };
                @endphp
                <flux:icon.{{ $iconName }} variant="outline" class="size-5 text-zinc-600 dark:text-zinc-300" />
            </div>
            <span class="text-xl font-bold text-zinc-900 dark:text-white uppercase">{{ $wallet->name }}</span>
        </div>

        <!-- QR Code Placeholder -->
        <div class="mb-6 flex justify-center">
            <div class="p-2 bg-white rounded-lg">
                {{-- QR code generation would go here. Using a placeholder image or div for now --}}
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $wallet->address }}"
                    alt="QR Code" class="size-32">
            </div>
        </div>

        <!-- Address -->
        <div class="mb-6">
            <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">عنوان المحفظة</div>
            <div
                class="flex items-center justify-between bg-zinc-200 dark:bg-zinc-900 p-3 rounded-lg border border-zinc-300 dark:border-zinc-700">
                <span
                    class="text-xs text-zinc-800 dark:text-zinc-200 truncate mr-2 font-mono">{{ $wallet->address }}</span>
                <button onclick="navigator.clipboard.writeText('{{ $wallet->address }}'); alert('تم النسخ')"
                    class="px-3 py-1 bg-zinc-800 hover:bg-zinc-700 text-white text-xs rounded-md transition-colors">
                    نسخ
                </button>
            </div>
        </div>

        <hr class="border-zinc-200 dark:border-zinc-700 my-6">

        <!-- Form -->
        <div class="space-y-4">
            <flux:input wire:model="amount" label="المبلغ المرسل" type="number" step="0.01"
                placeholder="أدخل المبلغ الذي قمت بتحويله" />

            <flux:button wire:click="save" variant="primary" class="w-full">
                اكتملت عملية إعادة الشحن
            </flux:button>
        </div>

        <!-- Warning/Info Block -->
        <div
            class="mt-6 p-4 bg-zinc-100 dark:bg-zinc-900/50 rounded-lg border border-zinc-200 dark:border-zinc-700 text-right text-sm text-zinc-600 dark:text-zinc-400 space-y-2">
            <p>1. لإعادة شحن {{ $wallet->name }} انسخ العنوان أعلاه أو امسح رمز الاستجابة السريعة.</p>
            <p>2. قد تستغرق عملية الإيداع من دقيقة إلى 15 دقيقة لتظهر في حسابك.</p>
            <p>3. إذا لم يصل الرصيد لفترة طويلة، يرجى تحديث الصفحة أو الاتصال بخدمة العملاء.</p>
        </div>
    </div>
</div>