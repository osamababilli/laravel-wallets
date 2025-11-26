<x-layouts.app :title="__('Wallet Dashboard')">
    {{-- إضافة مسافة بادئة شاملة وتغيير التباعد إلى gap-8 --}}
    {{-- **إضافة خاصية dir="rtl" لدعم اللغة العربية** --}}
    <div class="flex h-full w-full flex-col gap-8 p-4 sm:p-6">

        {{-- مجموعة البطاقات الرئيسية والأزرار - Grid ثلاثي الأعمدة (md:grid-cols-3) --}}
        <div class="grid gap-6 md:grid-cols-3">

            {{-- 💳 بطاقة المحفظة الرئيسية (الرصيد) - تصميم نظيف --}}
            <div
                class="relative p-6 rounded-2xl min-h-48 md:col-span-2
                       bg-white dark:bg-zinc-800 dark:shadow-zinc-950/50
                       border border-neutral-200 dark:border-zinc-700">

                <div class="z-10 flex flex-col justify-between h-full">
                    <div class="mb-4">
                        <flux:subheading class="text-gray-500 dark:text-gray-400">{{ __('USDT Wallet') }}
                        </flux:subheading>
                        <flux:heading size="xl"
                            class="font-extrabold text-3xl tracking-tight text-gray-900
                            dark:text-white">
                            $ 1,250.00
                        </flux:heading>
                    </div>

                    {{-- تمييز الربح باللون الأخضر الواضح --}}
                    <div class="flex items-center gap-2 font-semibold text-base text-green-600 dark:text-green-400">
                        <flux:icon name="arrow-up-right" class="size-5" />
                        {{ __('+$150 today') }}
                    </div>
                </div>
            </div>


            {{-- 🔗 بطاقة الإجراءات (Deposit/Withdraw) - تصميم نظيف --}}
            <div
                class="relative flex flex-col justify-center gap-4 p-6 rounded-2xl min-h-48
                       bg-white dark:bg-zinc-800 dark:shadow-zinc-950/50
                       border border-neutral-200 dark:border-zinc-700">

                {{-- زر الإيداع (Deposit) --}}
                <flux:button icon="arrow-down-circle" variant="primary" class="justify-center w-full">
                    {{ __('Deposit') }}
                </flux:button>

                {{-- زر السحب (Withdraw) --}}
                <flux:button icon="arrow-up-circle" variant="primary" class="justify-center w-full">
                    {{ __('Withdraw') }}
                </flux:button>
            </div>
        </div>




        {{-- 🧾 أحدث الحركات (Recent Transactions) - تصميم جدول Flux النظيف --}}
        <div
            class="relative rounded-2xl bg-white dark:bg-zinc-800 overflow-hidden border border-neutral-200 dark:border-zinc-700">

            {{-- رأس البطاقة --}}
            <div class="p-6 border-b border-neutral-100 dark:border-zinc-700/50">
                <flux:heading size="xl" class="font-semibold text-gray-800 dark:text-white">
                    {{ __('Recent Transactions') }}
                </flux:heading>
                <flux:subheading class="mt-1 text-gray-500 dark:text-gray-400">
                    {{ __('Your latest deposits and withdrawals.') }}
                </flux:subheading>
            </div>

            {{-- مكون الجدول من Flux/Tailwind CSS --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-100 dark:divide-zinc-700">

                    {{-- رأس الجدول --}}
                    <thead class="bg-neutral-50 dark:bg-zinc-700/70">
                        <tr>
                            {{-- المحاذاة أصبحت text-start (يمين في RTL) --}}
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Type') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Description') }}
                            </th>
                            {{-- المحاذاة أصبحت text-end (يسار في RTL) --}}
                            <th scope="col"
                                class="px-6 py-3 text-end text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Amount') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-end text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Date') }}
                            </th>
                        </tr>
                    </thead>

                    {{-- جسم الجدول --}}
                    <tbody class="divide-y divide-neutral-100 dark:divide-zinc-700/50">

                        {{-- الحركة 1: إيداع --}}
                        <tr class="hover:bg-neutral-50/50 dark:hover:bg-zinc-700/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                    {{-- **استخدام me-2 (margin-end)** لدعم RTL --}}
                                    <flux:icon name="banknotes" class="size-4 me-2" />
                                    {{ __('Deposit') }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-start">
                                {{ __('Transfer from Binance') }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-end text-base font-semibold text-green-600 dark:text-green-400">
                                +50.00 USDT
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm text-gray-500 dark:text-gray-400">
                                {{ __('25 Nov, 2025') }}
                            </td>
                        </tr>

                        {{-- الحركة 2: سحب --}}
                        <tr class="hover:bg-neutral-50/50 dark:hover:bg-zinc-700/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800 dark:bg-red-900/40 dark:text-red-300">
                                    <flux:icon name="arrow-path" class="size-4 me-2" />
                                    {{ __('Withdrawal') }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-start">
                                {{ __('Payment to Merchant X') }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-end text-base font-semibold text-red-600 dark:text-red-400">
                                -20.00 USDT
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm text-gray-500 dark:text-gray-400">
                                {{ __('24 Nov, 2025') }}
                            </td>
                        </tr>

                        {{-- الحركة 3: إيداع --}}
                        <tr class="hover:bg-neutral-50/50 dark:hover:bg-zinc-700/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                    <flux:icon name="banknotes" class="size-4 me-2" />
                                    {{ __('Deposit') }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-start">
                                {{ __('Interest Payment') }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-end text-base font-semibold text-green-600 dark:text-green-400">
                                +100.00 USDT
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm text-gray-500 dark:text-gray-400">
                                {{ __('23 Nov, 2025') }}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- تذييل الجدول --}}
            <div
                class="p-4 bg-neutral-50 dark:bg-zinc-800/50 border-t border-neutral-100 dark:border-zinc-700/50 text-center">
                <flux:button href="{{ route('transactions.index') }}" variant="subtle"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                    {{ __('View All Transactions') }}
                </flux:button>
            </div>
        </div>

    </div>
</x-layouts.app>
