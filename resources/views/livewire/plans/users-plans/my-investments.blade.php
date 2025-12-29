<div>



    <!-- Header -->
    <div class="space-y-2">
        <flux:heading size="xl">
            {{ __('My Investments') }}
        </flux:heading>

        <flux:subheading>
            {{ __('View and manage your investments') }}
        </flux:subheading>

        <flux:separator class="mt-5" />
    </div>





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
                        <th scope="col" class="px-4 py-3 text-center">{{ __('الربح اليومي') }}</th>
                        <th scope="col" class="px-4 py-3 text-center">{{ __('اجمالي الربح ') }}</th>
                        <th scope="col" class="px-4 py-3 text-center">{{ __('Subscribe Duration') }}</th>
                        <th scope="col" class="px-4 py-3 text-center">{{ __('Status') }}</th>

                        <th scope="col" class="px-4 py-3 text-center">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inverstments as $inverstment)
                    <tr class="border-b dark:border-gray-700">
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $inverstment->plan->name }}</th>

                        {{-- @dd($inverstment->plan->name) --}}
                        <td class="px-4 py-3">{{ $inverstment->plan->amount }} USDT</td>
                        <td class="px-4 py-3">{{ __(\Str::ucfirst($inverstment->plan->type)) }}
                            {{ $inverstment->plan->profit }} USDT </td>
                        <td class="px-4 py-3">

                            {{-- @php
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
                            @endphp --}}
                            {{-- @dd(number_format($inverstment->getCurrentProfit(), 2)) ; --}}
                            {{ number_format($inverstment->getCurrentProfit(), 2) }} USDT





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
                            if ($diff->h > 0 && count($parts) < 2) { $parts[]=$diff->h . ($isArabic ? ' ساعة' : 'h');
                                }
                                if ($diff->i > 0 && count($parts) < 2) { $parts[]=$diff->i . ($isArabic ? ' دقيقة' :
                                    'm');
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
                                $createdAt = $inverstment->created_at;
                                $now = now();

                                // حساب الأيام الكاملة الممضية
                                $daysPassed = $createdAt->diffInDays($now);

                                $planDurationDays = match ($inverstment->plan->type) {
                                'daily' => 1,
                                'weekly' => 7,
                                'monthly' => 30,
                                'yearly' => 365,
                                default => 0,
                                };

                                $currentProfit = $inverstment->getCurrentProfit();

                                // التحقق من وجود طلب سحب معلق
                                $hasPendingWithdrawal = $inverstment
                                ->profitWithdrawals()
                                ->where('status', 'pending')
                                ->exists();

                                // حساب الأيام المتبقية (عدد صحيح)
                                $daysRemaining = max(0, $planDurationDays - $daysPassed);

                                // حساب الساعات المتبقية إذا كان أقل من يوم
                                $hoursRemaining = 0;
                                if ($daysRemaining == 0 && $daysPassed < $planDurationDays) { $totalHours=$createdAt->
                                    diffInHours($now);
                                    $requiredHours = $planDurationDays * 24;
                                    $hoursRemaining = max(0, $requiredHours - $totalHours);
                                    }
                                    @endphp

                                    @if ($hasPendingWithdrawal)
                                    <!-- رسالة طلب قيد المراجعة -->
                                    <div
                                        class="flex items-center gap-2 px-3 py-2 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-clock text-yellow-600 dark:text-yellow-400">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12 6 12 12 16 14" />
                                        </svg>
                                        <span class="text-xs font-medium text-yellow-700 dark:text-yellow-300">
                                            {{ __('Withdrawal request pending review') }}
                                        </span>
                                    </div>
                                    @elseif ($daysPassed >= $planDurationDays && $currentProfit > 0)
                                    <!-- زر سحب الأرباح -->
                                    <a href="javascript:void(0)"
                                        wire:click="withdrawProfit('{{ $inverstment->id }}', {{ number_format($currentProfit, 2, '.', '') }})"
                                        class="flex items-center justify-center text-xs font-medium text-green-600 dark:text-green-400
                                            hover:text-white hover:bg-green-600 dark:hover:bg-green-500
                                            border border-green-600 dark:border-green-500
                                            rounded-lg px-3 py-2
                                            transition-all duration-200 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-download">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="7 10 12 15 17 10" />
                                            <line x1="12" x2="12" y1="15" y2="3" />
                                        </svg>
                                        <span class="ml-1.5">{{ __('Withdraw Profit') }}</span>

                                    </a>

                                    <!-- زر إنهاء الاستثمار -->
                                    <a href="javascript:void(0)"
                                        wire:click="leaveInvestment('{{ $inverstment->id }}', '{{ number_format($currentProfit, 2, '.', '') }}')"
                                        wire:confirm="{{ __('Are you sure you want to leave this investment? You will receive your initial amount plus any remaining profits.') }}"
                                        class="flex items-center justify-center text-xs font-medium text-red-600 dark:text-red-400
                                            hover:text-white hover:bg-red-600 dark:hover:bg-red-500
                                            border border-red-600 dark:border-red-500
                                            rounded-lg px-3 py-2
                                            transition-all duration-200 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-log-out">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" x2="9" y1="12" y2="12" />
                                        </svg>
                                        <span class="ml-1.5">{{ __('Leave Investment') }}</span>
                                    </a>
                                    @elseif ($daysPassed < $planDurationDays) <!-- رسالة الانتظار -->
                                        <div
                                            class="flex items-center gap-2 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-info text-blue-600 dark:text-blue-400">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M12 16v-4" />
                                                <path d="M12 8h.01" />
                                            </svg>
                                            <span class="text-xs font-medium text-blue-700 dark:text-blue-300">
                                                {{ __('Available in') }}
                                                @if ($daysRemaining > 0)
                                                {{ intval($daysRemaining) }} {{ __('days') }}
                                                @elseif ($hoursRemaining > 0)
                                                {{ $hoursRemaining }} {{ __('hours') }}
                                                @else
                                                {{ __('less than 1 hour') }}
                                                @endif
                                            </span>
                                        </div>
                                        @else
                                        <!-- لا توجد أرباح -->
                                        <div
                                            class="flex items-center gap-2 px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-alert-circle text-gray-500 dark:text-gray-400">
                                                <circle cx="12" cy="12" r="10" />
                                                <line x1="12" x2="12" y1="8" y2="12" />
                                                <line x1="12" x2="12.01" y1="16" y2="16" />
                                            </svg>
                                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">
                                                {{ __('No profits available') }}
                                            </span>
                                        </div>
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


    </div>
</div>