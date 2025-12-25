<div>

    <!-- Start coding here -->
    <div class="bg-white dark:bg-zinc-800  relative  overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full md:w-1/2">

            </div>




            <div class="w-full flex flex-row md:flex-row md:items-center md:justify-end gap-2 md:gap-3">



            </div>



        </div>


        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center text-gray-500 dark:text-zinc-400 dark:border-gray-700 rounded-md">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-700  dark:text-zinc-400">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-center">{{ __('Plan Name') }}</th>
                        <th scope="col" class="px-4 py-3 text-center">{{ __('Required Amount') }}</th>
                        <th scope="col" class="px-4 py-3 text-center">{{ __('Profit') }}</th>
                        <th scope="col" class="px-4 py-3 text-center">{{ __('Current Profit ') }}</th>
                        <th scope="col" class="px-4 py-3 text-center">{{ __('Subscribe Duration') }}</th>
                        <th scope="col" class="px-4 py-3 text-center">{{ __('Status') }}</th>

                        <th scope="col" class="px-4 py-3 text-center">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $inverstment)
                        <tr class="border-b dark:border-gray-700">
                            <th scope="row"
                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $inverstment->plan->name }}</th>

                            {{-- @dd($inverstment->plan->name) --}}
                            <td class="px-4 py-3">{{ $inverstment->plan->amount }} USDT</td>
                            <td class="px-4 py-3">{{ \Str::ucfirst($inverstment->plan->type) }}
                                {{ $inverstment->plan->profit }} USDT </td>
                            <td class="px-4 py-3">

                                @php
                                    $profit = $inverstment->plan->profit;
                                    $type = $inverstment->plan->type;

                                    // حساب الساعات من آخر سحب (أو من تاريخ الاشتراك إذا ما في سحب سابق)
                                    $lastWithdrawal = $inverstment->last_withdrawal_at
                                        ? \Carbon\Carbon::parse($inverstment->last_withdrawal_at)
                                        : null;

                                    $startDate = $lastWithdrawal ?? $inverstment->created_at;

                                    $hoursPassed = $startDate->diffInHours(now());

                                    // حساب الربح حسب نوع الخطة
                                    $currentProfit = match ($type) {
                                        'daily' => function () use ($hoursPassed, $profit) {
                                            $hoursInDay = 24;
                                            $daysCompleted = floor($hoursPassed / $hoursInDay);
                                            return $profit * $daysCompleted;
                                        },

                                        'weekly' => function () use ($hoursPassed, $profit) {
                                            $hoursInWeek = 168; // 7 * 24
                                            $weeksCompleted = floor($hoursPassed / $hoursInWeek);
                                            return $profit * $weeksCompleted;
                                        },

                                        'monthly' => function () use ($hoursPassed, $profit) {
                                            $hoursInMonth = 720; // 30 * 24
                                            $monthsCompleted = floor($hoursPassed / $hoursInMonth);
                                            return $profit * $monthsCompleted;
                                        },

                                        'yearly' => function () use ($hoursPassed, $profit) {
                                            $hoursInYear = 8760; // 365 * 24
                                            $yearsCompleted = floor($hoursPassed / $hoursInYear);
                                            return $profit * $yearsCompleted;
                                        },

                                        default => fn() => 0,
                                    };

                                    $currentProfit = $currentProfit();
                                @endphp

                                {{ number_format($currentProfit, 2) }} USDT




                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $diff = $inverstment->created_at->diff(now());

                                    $isArabic = app()->getLocale() === 'ar';

                                    $parts = [];

                                    if ($diff->y > 0) {
                                        $parts[] = $diff->y . ($isArabic ? ' سنة' : 'y');
                                    }
                                    if ($diff->m > 0) {
                                        $parts[] = $diff->m . ($isArabic ? ' شهر' : 'mo');
                                    }
                                    if ($diff->d > 0) {
                                        $parts[] = $diff->d . ($isArabic ? ' يوم' : 'd');
                                    }
                                    if ($diff->h > 0 && count($parts) < 2) {
                                        $parts[] = $diff->h . ($isArabic ? ' ساعة' : 'h');
                                    }
                                    if ($diff->i > 0 && count($parts) < 2) {
                                        $parts[] = $diff->i . ($isArabic ? ' دقيقة' : 'm');
                                    }

                                    if (empty($parts)) {
                                        $result = $isArabic ? 'الآن' : 'now';
                                    } else {
                                        $separator = $isArabic ? ' و ' : ' ';
                                        $prefix = $isArabic ? 'منذ ' : '';
                                        $suffix = $isArabic ? '' : ' ago';

                                        $result = $prefix . implode($separator, array_slice($parts, 0, 2)) . $suffix;
                                    }
                                @endphp

                                <span class="text-gray-600 dark:text-gray-400">
                                    {{ $result }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center items-center">
                                    @if ($inverstment->status === 'active')
                                        <flux:icon name="circle-check-big" class="text-green-500 w-6 h-6 text-center" />
                                    @else
                                        <flux:icon name="circle-x" class="text-red-500 w-6 h-6" />
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3 flex items-center justify-center">
                                <div class="flex flex-row items-center justify-center gap-2">
                                    @php
                                        $daysPassed = $inverstment->created_at->diffInDays(now());
                                        $planDurationDays = match ($inverstment->plan->type) {
                                            'daily' => 1,
                                            'weekly' => 7,
                                            'monthly' => 30,
                                            'yearly' => 365,
                                            default => 0,
                                        };
                                    @endphp

                                    @if ($daysPassed >= $planDurationDays)
                                        <a href="javascript:void(0)"
                                            wire:click="withdrawProfit('{{ $inverstment->id }}', {{ $currentProfit }})"
                                            class="flex items-center justify-center text-xs
                                            hover:text-green-500 hover:bg-gray-200/25 hover:rounded-md
                                            p-1.5 transition-[color,background-color,border-radius] duration-200 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-square-pen-icon lucide-square-pen">
                                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path
                                                    d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                            </svg>
                                            <span class="mx-1"> {{ __('Withdraw Profit') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center ">
                                <div class="flex flex-row items-center justify-center gap-2">
                                    <span>
                                        <svg class="w-8 h-8 text-gray-400" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </span>
                                    <div>
                                        {{ __('No data found') }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $members->links() }}

    </div>
</div>
