<div>

    <!-- Start coding here -->
    <div class="bg-white dark:bg-zinc-800  relative  overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full md:w-1/2">
                <form class="flex items-center">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-zinc-400" fill="currentColor"
                                viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live="search" type="text" id="simple-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-zinc-500 focus:border-zinc-500 block w-full pl-10 p-2 dark:bg-zinc-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                            placeholder="Search" required="">
                    </div>
                </form>
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
                    @forelse ($inverstments as $inverstment)
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
                                    $profit = $inverstment->plan->profit; // الربح اليومي: 161 USDT
                                    $type = $inverstment->plan->type; // daily

                                    $hoursPassed = $inverstment->created_at->diffInHours(now());

                                    // حساب الربح حسب نوع الخطة
                                    $currentProfit = match ($type) {
                                        'daily' => function () use ($hoursPassed, $profit) {
                                            // الربح اليومي الثابت: 161 USDT
                                            // كل 24 ساعة = 161 USDT
                                            $hoursInDay = 24;
                                            $daysCompleted = floor($hoursPassed / $hoursInDay);

                                            return $profit * $daysCompleted;
                                        },

                                        'weekly' => function () use ($hoursPassed, $profit) {
                                            // كل 7 أيام = الربح المحدد
                                            $hoursInWeek = 168; // 7 * 24
                                            $weeksCompleted = floor($hoursPassed / $hoursInWeek);

                                            return $profit * $weeksCompleted;
                                        },

                                        'monthly' => function () use ($hoursPassed, $profit) {
                                            // كل 30 يوم = الربح المحدد
                                            $hoursInMonth = 720; // 30 * 24
                                            $monthsCompleted = floor($hoursPassed / $hoursInMonth);

                                            return $profit * $monthsCompleted;
                                        },

                                        'yearly' => function () use ($hoursPassed, $profit) {
                                            // كل 365 يوم = الربح المحدد
                                            $hoursInYear = 8760; // 365 * 24
                                            $yearsCompleted = floor($hoursPassed / $hoursInYear);

                                            return $profit * $yearsCompleted;
                                        },

                                        default => fn() => 0,
                                    };

                                    $currentProfit = $currentProfit();
                                @endphp

                                {{ $currentProfit }} USDT




                            </td>
                            <td class="px-4 py-3"> {{ $inverstment->created_at->diffForHumans() }}
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

                                    <a href="javascript:void(0)" wire:click="EditPlan('{{ $inverstment->id }}')"
                                        class="flex items-center justify-center text-xs
                                            hover:text-green-500 hover:bg-gray-200/25 hover:rounded-md
                                            p-1.5 transition-[color,background-color,border-radius] duration-200 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-square-pen-icon lucide-square-pen">
                                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path
                                                d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                        </svg>
                                    </a>


                                    <a href="javascript:void(0)" wire:click="delete('{{ $inverstment->id }}')"
                                        class="flex items-center justify-center text-xs
                                            hover:text-red-500 hover:bg-gray-200/25 hover:rounded-md
                                            p-1.5 transition-[color,background-color,border-radius] duration-200 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-trash-icon lucide-trash">
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                    </a>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="px-4 py-12 text-center ">
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
