<div>

    <div class="relative rounded-2xl bg-white dark:bg-zinc-800 overflow-hidden  ">

        {{-- رأس البطاقة --}}
        <div class="p-6 border-b border-neutral-100 dark:border-zinc-700/50">
            <flux:heading size="xl" class="font-semibold text-gray-800 dark:text-white">
                {{ __('Wallet Requests') }}
            </flux:heading>
            <flux:subheading class="mt-1 text-gray-500 dark:text-gray-400">
                {{ __('All Wallet Requests') }}
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
                            {{ __('USER') }}
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
                        @hasrole('super admin')
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        @endhasrole
                    </tr>
                </thead>

                {{-- جسم الجدول --}}
                <tbody class="divide-y divide-neutral-100 dark:divide-zinc-700/50">

                    @forelse ($requests as $trans)
                        {{-- الحركة 1: إيداع --}}
                        <tr class="hover:bg-neutral-50/50 dark:hover:bg-zinc-700/50 transition duration-150">
                            <td class="px-6 flex flex-col items-center  py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium @if ($trans->type == 'deposit') text-green-800 dark:text-green-400 dark:bg-green-900/50  @else bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400 @endif">
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
                                    <a href="{{ route('users.show', $trans->user->id) }}"> {{ $trans->user->name }}</a>
                                </td>
                            @endhasrole
                            <td
                                class="px-6 py-4 whitespace-nowrap text-center text-base font-semibold @if ($trans->type == 'deposit') text-green-600  dark:text-green-400 @else text-red-600 dark:text-red-400 @endif ">
                                {{ $trans->amount }} USDT
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                {{ $trans->created_at->format('d M, Y') }}
                            </td>
                            @hasrole('super admin')
                                <td class="px-4 py-3 flex items-center justify-center">
                                    @if ($trans->status == 'pending')
                                        <div class="flex flex-row items-center justify-center gap-2">



                                            <a href="javascript:void(0);" wire:click="acceptRquest({{ $trans->id }})"
                                                class="flex items-center justify-center text-xs
                                            hover:text-green-500 hover:bg-gray-200/25 hover:rounded-md
                                            p-1.5 transition-[color,background-color,border-radius] duration-200 ease-in-out">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-check-icon lucide-check">
                                                    <path d="M20 6 9 17l-5-5" />
                                                </svg>
                                            </a>


                                        </div>
                                        <div class="flex flex-row items-center justify-center gap-2">



                                            <a href="javascript:void(0);" wire:click="rejectRquest({{ $trans->id }})"
                                                class="flex items-center justify-center text-xs
                                            hover:text-red-500 hover:bg-gray-200/25 hover:rounded-md
                                            p-1.5 transition-[color,background-color,border-radius] duration-200 ease-in-out">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-x-icon lucide-x">
                                                    <path d="M18 6 6 18" />
                                                    <path d="m6 6 12 12" />
                                                </svg>
                                            </a>


                                        </div>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/50 dark:text-green-400">
                                            {{ __('Processed') }}
                                        </span>
                                    @endif
                                </td>
                            @endhasrole
                        </tr>

                    @empty
                    @endforelse


                </tbody>

            </table>
            {{ $requests->links() }}
        </div>


    </div>
</div>
