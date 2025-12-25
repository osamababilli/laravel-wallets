<div class="w-full">
    <!-- Header -->
    <div class="space-y-2">
        <flux:heading size="xl">
            {{ __('Investment Plans') }}
        </flux:heading>

        <flux:subheading>
            {{ __('Set up your investment plan and start making money') }}
        </flux:subheading>

        <flux:separator class="mt-5" />
    </div>

    <!-- Plans Grid -->
    <div class="mt-6 w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($plans as $plan)
            <div
                class="group relative flex flex-col justify-between p-8 rounded-2xl bg-gradient-to-br from-white to-gray-50 dark:from-zinc-800 dark:to-zinc-900 border border-neutral-200 dark:border-zinc-700 shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300  ">



                <!-- Plan Details -->

                <div class="text-center space-y-6 mt-2">
                    <!-- Plan Name -->
                    <div>
                        <h3
                            class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                            {{ $plan->name }}
                        </h3>
                    </div>

                    <!-- Divider -->
                    <div class="w-16 h-1 mx-auto  bg-gray-900 dark:bg-white  rounded-full"></div>

                    <!-- Amount -->
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-medium">
                            {{ __('Required Amount') }}
                        </p>
                        <p class="text-4xl font-bold text-gray-900 dark:text-white">
                            {{ $plan->amount }} <span class="text-2xl text-gray-600 dark:text-gray-400">USDT</span>
                        </p>
                    </div>

                    <!-- Profit Card -->
                    <div
                        class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                        <p class="text-xs uppercase tracking-wide text-green-700 dark:text-green-400 font-medium mb-1">
                            {{ __('Net Profits') }}
                        </p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ $plan->profit }} <span class="text-2xl text-green-600 dark:text-green-400">USDT</span>
                            {{ __(Str::ucfirst($plan->type)) }}
                        </p>

                    </div>


                </div>


                <!-- Action Button -->
                <flux:button type="submit" variant="primary" wire:click="subscribe({{ $plan->id }})"
                    class="mt-8 w-full cursor-pointer text-base font-semibold py-3   transform hover:-translate-y-1 transition-all duration-200 shadow-lg hover:shadow-xl">
                    {{ __('Start Investing Now') }}
                </flux:button>
            </div>
        @empty
        @endforelse
    </div>
</div>
