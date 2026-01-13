<div>

    <!-- Header -->
    <div class="space-y-2 mb-5">
        <flux:heading size="xl">
            {{ __('Profit Withdrawals History') }}
        </flux:heading>

        <flux:subheading>
            {{ __('All Profit Withdrawals') }}
        </flux:subheading>

        <flux:separator class="mt-5" />
    </div>

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


    <div class="relative rounded-2xl bg-white dark:bg-zinc-800 overflow-hidden  ">




        {{-- مكون الجدول من Flux/Tailwind CSS --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-100 dark:divide-zinc-700">

                {{-- رأس الجدول --}}
                <thead class="bg-neutral-50 dark:bg-zinc-700/70">
                    <tr>
                        {{-- المحاذاة أصبحت text-center (يمين في RTL) --}}
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Plan name') }}
                        </th>
                        @hasrole('super admin')
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('USER') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('معرف العميل') }}
                        </th>
                        @endhasrole
                        {{-- المحاذاة أصبحت text-center(يسار في RTL) --}}
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Profit') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Network') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Address') }}
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

                    @forelse ($history as $trans)
                    {{-- الحركة 1: إيداع --}}
                    <tr class="hover:bg-neutral-50/50 dark:hover:bg-zinc-700/50 transition duration-150">
                        <td class="px-6 flex flex-col items-center  py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $trans->investment->plan->name }} </div>



                        </td>
                        @hasrole('super admin')
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-center">
                            <a href="{{ route('users.show', $trans->user->id) }}"> {{ $trans->user->name }}</a>
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-center">
                            {{ $trans->user->user_number }}
                        </td>
                        @endhasrole
                        <td
                            class="px-6 py-4 whitespace-nowrap text-center text-base font-semibold  text-green-600  dark:text-green-400 ">
                            @hasrole('super admin')
                            {{ $trans->net_amount }} USDT <br>
                            @else
                            {{ $trans->amount }} USDT
                            @endhasrole
                        </td>


                        <td class="px-6 py-4 whitespace-nowrap text-center text-base font-semibold ">
                            <span>
                                @if ($trans->status == 'pending')
                                <flux:badge variant="pill" color="yellow">{{ __('Pending') }}</flux:badge>
                                @elseif($trans->status == 'approved')
                                <flux:badge variant="pill" color="green">{{ __('Approved') }}</flux:badge>
                                @elseif($trans->status == 'rejected')
                                <flux:badge variant="pill" color="red">{{ __('Rejected') }}</flux:badge>
                                @endif
                            </span>
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-center text-base font-semibold text-gray-700 dark:text-gray-300">
                            {{ $trans->network ?? '-' }}
                        </td>
                        <td onclick="navigator.clipboard.writeText('{{ $trans->wallet_address }}'); alert('{{ __('Address Copied') }}')"
                            class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400 cursor-pointer hover:text-blue-500 transition-colors group relative"
                            title="{{ $trans->wallet_address }}">
                            <div class="flex items-center justify-center gap-2">
                                <span class="truncate max-w-[150px]">{{ $trans->wallet_address ?? '-' }}</span>
                                <flux:icon.document-duplicate
                                    class="size-4 opacity-0 group-hover:opacity-100 transition-opacity" />
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-check-icon lucide-check">
                                        <path d="M20 6 9 17l-5-5" />
                                    </svg>
                                </a>


                            </div>
                            <div class="flex flex-row items-center justify-center gap-2">



                                <a href="javascript:void(0);" wire:click="rejectRquest({{ $trans->id }})"
                                    class="flex items-center justify-center text-xs
                                            hover:text-red-500 hover:bg-gray-200/25 hover:rounded-md
                                            p-1.5 transition-[color,background-color,border-radius] duration-200 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
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

                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center ">
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
            {{ $history->links() }}
        </div>


    </div>
</div>