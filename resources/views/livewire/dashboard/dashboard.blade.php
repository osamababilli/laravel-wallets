<div>
    {{-- إضافة مسافة بادئة شاملة وتغيير التباعد إلى gap-8 --}}
    {{-- **إضافة خاصية dir="rtl" لدعم اللغة العربية** --}}



    @php

    @endphp

    <flux:modal name="DepositModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Deposit USDT') }}</flux:heading>
            </div>
            <flux:input wire:model.live='depositAmount' type="number" label="{{ __('Amount') }}" />
            <flux:select label="{{ __('Select Wallet') }}">
                @foreach ($cryptos as $wallet)
                    <flux:select.option value="{{ $wallet->address }}">{{ $wallet->address }}</flux:select.option>
                @endforeach
            </flux:select>
            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="deposit" type="submit" variant="primary">{{ __('submit') }}</flux:button>
            </div>
        </div>
    </flux:modal>
    <flux:modal name="WithdrawModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Withdrawal USDT') }}</flux:heading>
            </div>
            <flux:input wire:model.live='depositAmount' type="number" label="{{ __('Amount') }}" />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="Withdraw" type="submit" variant="primary">{{ __('submit') }}</flux:button>
            </div>
        </div>
    </flux:modal>
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
                            {{ Auth::user()->balance ?? '0.00' }} USDT
                        </flux:heading>
                    </div>

                    {{-- تمييز الربح باللون الأخضر الواضح --}}
                    <div class="flex items-center gap-2 font-semibold text-base text-green-600 dark:text-green-400">

                        {{ Auth::user()->transactions()->count() }} {{ __('Transactions') }}
                    </div>
                </div>
            </div>



            {{-- 🔗 بطاقة الإجراءات (Deposit/Withdraw) - تصميم نظيف --}}
            <div
                class="relative flex flex-col justify-center gap-4 p-6 rounded-2xl min-h-48
                       bg-white dark:bg-zinc-800 dark:shadow-zinc-950/50
                       border border-neutral-200 dark:border-zinc-700">

                {{-- زر الإيداع (Deposit) --}}

                <flux:modal.trigger name="DepositModal">
                    <flux:button icon="arrow-down-circle" variant="primary" class="justify-center w-full">
                        {{ __('Deposit') }}
                    </flux:button>
                </flux:modal.trigger>

                <flux:modal.trigger name="WithdrawModal">
                    {{-- زر السحب (Withdraw) --}}
                    <flux:button icon="arrow-up-circle" variant="primary" class="justify-center w-full">
                        {{ __('Withdraw') }}
                    </flux:button>
                </flux:modal.trigger>
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
                            {{-- المحاذاة أصبحت text-center (يمين في RTL) --}}
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Type') }}
                            </th>
                            @hasrole('super admin')
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('User') }}
                                </th>
                            @endhasrole
                            {{-- المحاذاة أصبحت text-center (يمين في RTL) --}}

                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('TXID') }}
                            </th>
                            {{-- المحاذاة أصبحت text-center(يسار في RTL) --}}
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Amount') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Date') }}
                            </th>
                        </tr>
                    </thead>

                    {{-- جسم الجدول --}}
                    <tbody class="divide-y divide-neutral-100 dark:divide-zinc-700/50">

                        @forelse ($data as $trans)
                            {{-- الحركة 1: إيداع --}}
                            <tr class="hover:bg-neutral-50/50 dark:hover:bg-zinc-700/50 transition duration-150">
                                <td class="px-6 flex flex-col items-center  py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium @if ($trans->type == 'withdraw') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400 @else text-green-800 dark:text-green-400 dark:bg-green-900/50 @endif">
                                        {{-- **استخدام me-2 (margin-end)** لدعم RTL --}}
                                        <flux:icon name="banknotes" class="size-4 me-2" />
                                        @if ($trans->type == 'deposit')
                                            {{ __('Deposit') }}
                                        @else
                                            {{ __('Withdrawal') }}
                                        @endif
                                    </span>
                                </td>
                                @hasrole('super admin')
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-center">
                                        {{ $trans->payable->name }}
                                    </td>
                                @endhasrole
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-center">
                                    {{ $trans->uuid }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-center text-base font-semibold @if ($trans->type == 'deposit') text-green-600  dark:text-green-400 @else text-red-600 dark:text-red-400 @endif ">
                                    {{ $trans->amount }} USDT
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                    {{ $trans->created_at->format('d M, Y') }}
                                </td>
                            </tr>

                        @empty
                        @endforelse


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

</div>
