<div>
    {{-- رأس البطاقة --}}
    <div class="py-6 border-b border-neutral-100 dark:border-zinc-700/50 mb-5">
        <flux:heading size="xl" class="font-semibold text-gray-800 dark:text-white">
            {{ __('Withdraw Requests') }}
        </flux:heading>
        <flux:subheading class="mt-1 text-gray-500 dark:text-gray-400">
            {{ __('All Withdraw Requests') }}
        </flux:subheading>
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
                            {{ __('Type') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('USER') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('معرف المستخدم') }}
                        </th>
                        {{-- المحاذاة أصبحت text-center(يسار في RTL) --}}
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Amount') }}
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
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status') }}
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
                        {{-- الحركة: سحب --}}
                        <tr class="hover:bg-neutral-50/50 dark:hover:bg-zinc-700/50 transition duration-150">
                            <td class="px-6 flex flex-col items-center  py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400">
                                    {{-- **استخدام me-2 (margin-end)** لدعم RTL --}}
                                    <flux:icon name="banknotes" class="size-4 me-2" />
                                    {{ __('Withdrawal') }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-center">
                                @if($trans->user)
                                    <a href="{{ route('users.show', $trans->user->id) }}"> {{ $trans->user->name }}</a>
                                @else
                                    Unknown
                                @endif
                            </td>
                              <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-center">
                               {{ $trans->user->user_number }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-center text-base font-semibold text-red-600 dark:text-red-400">
                                {{ $trans->amount }} USDT
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400 font-mono">
                                {{ $trans->network }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-xs text-gray-500 dark:text-gray-400 font-mono max-w-xs truncate cursor-pointer hover:text-blue-500 transition-colors group"
                                title="{{ $trans->wallet_address }}"
                                onclick="navigator.clipboard.writeText('{{ $trans->wallet_address }}'); alert('{{ __('Address Copied') }}')">
                                {{ \Illuminate\Support\Str::limit($trans->wallet_address, 15) }}
                                <flux:icon name="document-duplicate" class="size-3 inline-block ml-1 opacity-0 group-hover:opacity-100 transition-opacity" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                {{ $trans->created_at->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($trans->status == 'pending')
                                    <span
                                        class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400">{{ __('Pending') }}</span>
                                @elseif($trans->status == 'approved')
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-900/50 dark:text-green-400">{{ __('Approved') }}</span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-800 dark:bg-red-900/50 dark:text-red-400">{{ __('Rejected') }}</span>
                                @endif
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
                                        class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800 dark:bg-gray-700/50 dark:text-gray-300">
                                        {{ __('Processed') }}
                                    </span>
                                @endif
                            </td>
                            @endhasrole
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">No withdraw requests found.</td>
                        </tr>
                    @endforelse


                </tbody>

            </table>
            {{ $requests->links() }}
        </div>


    </div>
</div>