<div>

    <div class="relative rounded-2xl bg-white dark:bg-zinc-800 overflow-hidden  ">

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
                                {{ __('25 Nov, 2025') }}
                            </td>
                        </tr>

                    @empty
                    @endforelse


                </tbody>

            </table>
            {{ $data->links() }}
        </div>


    </div>
</div>
