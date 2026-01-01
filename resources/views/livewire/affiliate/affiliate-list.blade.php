<div>
    {{-- Header --}}
    <div class="py-6 border-b border-neutral-100 dark:border-zinc-700/50 mb-5">
        <flux:heading size="xl" class="font-semibold text-gray-800 dark:text-white">
            {{ __('Affiliate Profits') }}
        </flux:heading>
        <flux:subheading class="mt-1 text-gray-500 dark:text-gray-400">
            {{ __('List of all affiliate profits') }}
        </flux:subheading>
    </div>

    <div class="relative rounded-2xl bg-white dark:bg-zinc-800 overflow-hidden">
        {{-- Table Component --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-100 dark:divide-zinc-700">
                {{-- Table Header --}}
                <thead class="bg-neutral-50 dark:bg-zinc-700/70">
                    <tr>
                        @hasrole('super admin')
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('User') }}
                        </th>
                        @endhasrole
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Amount') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Date') }}
                        </th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-neutral-100 dark:divide-zinc-700/50">
                    @forelse ($profits as $profit)
                        <tr class="hover:bg-neutral-50/50 dark:hover:bg-zinc-700/50 transition duration-150">
                            @hasrole('super admin')
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-neutral-200 font-medium text-center">
                                @if($profit->user)
                                    <a href="{{ route('users.show', $profit->user->id) }}"> {{ $profit->user->name }}</a>
                                @else
                                    Unknown
                                @endif
                            </td>
                            @endhasrole
                            <td
                                class="px-6 py-4 whitespace-nowrap text-center text-base font-semibold text-green-600 dark:text-green-400">
                                {{ $profit->amount }} USDT
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-900/50 dark:text-green-400">
                                    {{ __('Received') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                {{ $profit->created_at->format('d M, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->hasRole('super admin') ? 4 : 3 }}"
                                class="text-center py-4 text-gray-500">
                                {{ __('No profits found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $profits->links() }}
        </div>
    </div>
</div>