<div>



    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 ">

        <div class="flex flex-row gap-6  items-center shadow-xs rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 ">
            <div class="p-4 rounded-lg bg-zinc-200 dark:bg-zinc-800">
                <flux:icon.plus class="text-zinc-400 dark:text-zinc-200 " />
            </div>
            <div>
                <flux:subheading size="xs"> {{ __('Created Events') }} </flux:subheading>
                <flux:heading size="xl" class="p-0 m-0">
                    {{ $allLogs->where('event', 'created')->count() ?? 0 }}</flux:heading>
            </div>
        </div>

        <div class="flex flex-row gap-6  items-center shadow-xs rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 ">
            <div class="p-4 rounded-lg bg-zinc-200 dark:bg-zinc-800">
                <flux:icon.rotate-ccw class="text-zinc-400 dark:text-zinc-200 " />
            </div>
            <div>
                <flux:subheading size="xs"> {{ __('Updated Events') }} </flux:subheading>
                <flux:heading size="xl" class="p-0 m-0">{{ $allLogs->where('event', 'updated')->count() ?? 0 }}
                </flux:heading>
            </div>
        </div>

        <div class="flex flex-row gap-6  items-center shadow-xs rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 ">
            <div class="p-4 rounded-lg bg-zinc-200 dark:bg-zinc-800">
                <flux:icon.trash class="text-zinc-400 dark:text-zinc-200 " />
            </div>
            <div>
                <flux:subheading size="xs"> {{ __('Deleted Events') }} </flux:subheading>
                <flux:heading size="xl" class="p-0 m-0">{{ $allLogs->where('event', 'deleted')->count() ?? 0 }}
                </flux:heading>
            </div>
        </div>

        <div class="flex flex-row gap-6  items-center shadow-xs rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 ">
            <div class="p-4 rounded-lg bg-zinc-200 dark:bg-zinc-800">
                <flux:icon.notepad-text class="text-zinc-400 dark:text-zinc-200 " />
            </div>
            <div>
                <flux:subheading size="xs"> {{ __('Total Events') }} </flux:subheading>
                <flux:heading size="xl" class="p-0 m-0">{{ $logs->count() ?? 0 }} </flux:heading>
            </div>
        </div>



    </div>



    <div class="overflow-x-auto mt-6 relative shadow-xs rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-zinc-400 dark:border-gray-700 rounded-md">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-700  dark:text-zinc-400">
                <tr>
                    <th scope="col" class="px-4 py-3">{{ __('Description') }}</th>
                    <th scope="col" class="px-4 py-3">{{ __('Causer') }}</th>
                    <th scope="col" class="px-4 py-3">{{ __('Model') }}</th>
                    <th scope="col" class="px-4 py-3">{{ __('Event') }}</th>
                    <th scope="col" class="px-4 py-3">{{ __('Properties') }}</th>
                    <th scope="col" class="px-4 py-3">{{ __('Logged At') }}</th>



                </tr>
            </thead>
            <tbody>
                {{-- @dd($logs) --}}
                @forelse ($logs as $log)
                    <tr class="border-b dark:border-gray-700">
                        <th scope="row"
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $log->description }}</th>

                        <td class="px-4 py-3"> {{ optional($log->causer)->name }}</td>
                        <td class="px-4 py-3">{{ class_basename($log->subject_type) }}</td>


                        <td class="px-4 py-3 ">

                            <flux:badge as="button" variant="pill" size="lg">
                                {{ $log->event }}
                            </flux:badge>


                        </td>

                        <td class="px-4 py-3 ">
                            <flux:textarea rows="auto" readonly class="w-full font-mono text-xs">

                                {{ json_encode($log->properties, JSON_PRETTY_PRINT) }}
                            </flux:textarea>



                        </td>
                        <td class="px-4 py-3 ">
                            {{ $log->created_at->diffForHumans() }}



                        </td>





                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center ">
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
        {{ $logs->links() }}
    </div>





</div>
