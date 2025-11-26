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


                @can('create language')
                    <!-- زر إنشاء دور -->
                    <div class="w-full md:w-auto">

                        <flux:modal.trigger name="languageFormModal">


                            <a href="javascript:void(0)"
                                class="w-full md:w-auto flex items-center justify-center gap-2
                  text-white bg-zinc-700 hover:bg-zinc-600
                  dark:bg-zinc-600 dark:hover:bg-zinc-700 dark:text-white
                  rounded-lg text-sm px-4 py-2 font-medium
                  focus:outline-none focus:ring-2 focus:ring-zinc-300">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2
                                                                                                                                                                                                                          0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                {{ __('Add New Language') }}
                            </a>
                        </flux:modal.trigger>
                    </div>



                    <flux:modal name="languageFormModal" class="w-full md:w-1/2" :dismissible="false">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">{{ __('Add New Language') }}</flux:heading>

                            </div>
                            <flux:input wire:model.live="name" label="{{ __('Name') }}"
                                placeholder="{{ __('Language Name') }}" />

                            <flux:input wire:model.live="code" label="{{ __('Code') }}"
                                placeholder="{{ __('Language Code (e.g., en, fr, ar)') }}" />

                            <flux:select wire:model.live="direction" label="{{ __('Direction') }}">
                                <option value="ltr">{{ __('Left to Right (LTR)') }}</option>
                                <option value="rtl">{{ __('Right to Left (RTL)') }}</option>
                            </flux:select>


                            <flux:checkbox wire:model.live="is_active" label="{{ __('Active') }}" />

                            @can('set default language')
                                <flux:checkbox wire:model.live="is_default" label="{{ __('Default') }}" />
                            @endcan
                            <div class="flex">
                                <flux:spacer />
                                <flux:button type="submit" wire:loading.attr="disabled" wire:target="saveLanguage"
                                    wire:click="saveLanguage" variant="primary">{{ __('Save') }}
                                </flux:button>
                            </div>
                        </div>
                    </flux:modal>
                @endcan



                <!-- زر الترتيب -->
                <div x-data="{ open: false }" class="w-full md:w-auto relative">
                    <!-- زر الفلترة -->
                    <button @click="open = !open"
                        class="w-full md:w-auto flex items-center justify-center gap-2
                        py-2 px-4 text-sm font-medium
                        text-zinc-900 bg-white border border-zinc-200
                        rounded-lg hover:bg-zinc-100 hover:text-primary-700
                        focus:outline-none focus:ring-2 focus:ring-zinc-200
                        dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-600
                        dark:hover:bg-zinc-700 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 text-zinc-400"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011
                            1v3a1 1 0 01-.293.707L12 11.414V15a1
                            1 0 01-.293.707l-2 2A1 1 0 018
                            17v-5.586L3.293 6.707A1 1 0 013
                            6V3z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Sort By') }}
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414
                            0L10 10.586l3.293-3.293a1 1 0
                            111.414 1.414l-4 4a1 1 0 01-1.414
                            0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>

                    <!-- القائمة المنسدلة -->
                    <div x-show="open" @click.outside="open = false" x-transition
                        class="z-10 absolute ltr:right-0 rtl:left-0 w-48 p-3 mt-2 bg-white rounded-lg shadow
                         dark:bg-zinc-700">
                        <div class="flex items-center mb-4">
                            <input checked id="default-radio-1" wire:model.live="sortDirection" type="radio"
                                value="desc"
                                class="w-4 h-4 text-blue-600 border-zinc-300
                       focus:ring-blue-500 dark:focus:ring-blue-600
                       dark:ring-offset-zinc-800 focus:ring-2
                       bg-zinc-100 dark:bg-zinc-700 dark:border-zinc-600">
                            <label for="default-radio-1"
                                class="ms-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">
                                {{ __('Descending') }}
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="default-radio-2" wire:model.live="sortDirection" type="radio" value="asc"
                                class="w-4 h-4 text-blue-600 border-zinc-300
                       focus:ring-blue-500 dark:focus:ring-blue-600
                       dark:ring-offset-zinc-800 focus:ring-2
                       bg-zinc-100 dark:bg-zinc-700 dark:border-zinc-600">
                            <label for="default-radio-2"
                                class="ms-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">
                                {{ __('Ascending') }}
                            </label>
                        </div>
                    </div>
                </div>

            </div>



        </div>

        <livewire:languages.language-edit />
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center text-gray-500 dark:text-zinc-400 dark:border-gray-700 rounded-md">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-700  dark:text-zinc-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">{{ __('Name') }}</th>
                        <th scope="col" class="px-4 py-3">{{ __('Code') }}</th>
                        <th scope="col" class="px-4 py-3">{{ __('Direction') }}</th>
                        <th scope="col" class="px-4 py-3">{{ __('Active') }}</th>
                        <th scope="col" class="px-4 py-3">{{ __('Default') }}</th>

                        @if (auth()->user()->can('edit language') || auth()->user()->can('delete language'))
                            <th scope="col" class="px-4 py-3 text-center">
                                {{ __('Actions') }}
                            </th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    @forelse ($languages as $language)
                        <tr class="border-b dark:border-gray-700">
                            <th scope="row"
                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $language->name }}</th>

                            <td class="px-4 py-3">{{ $language->code }}</td>
                            <td class="px-4 py-3">{{ strtoupper($language->direction) }}</td>



                            <td class="px-4 py-3">
                                <div class="flex flex-row items-center justify-center gap-2">
                                    @if ($language->is_active)
                                        <flux:icon name="circle-check-big"
                                            class="text-green-500 w-6 h-6 text-center" />
                                    @else
                                        <flux:icon name="circle-x" class="text-red-500 w-6 h-6" />
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-row items-center justify-center gap-2">
                                    @if ($language->is_default)
                                        <flux:icon name="circle-check-big"
                                            class="text-green-500 w-6 h-6 text-center" />
                                    @else
                                        <flux:icon name="circle-x" class="text-red-500 w-6 h-6" />
                                    @endif
                                </div>
                            </td>




                            <td class="px-4 py-3 flex items-center justify-center">


                                <div class="flex flex-row items-center justify-center gap-2">
                                    @can('edit language')
                                        <a href="{{ route('translations.index', $language->code) }}"
                                            class="flex items-center justify-center text-xs
                                            hover:text-green-500 hover:bg-gray-200/25 hover:rounded-md
                                            p-1.5 transition-[color,background-color,border-radius] duration-200 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-languages-icon lucide-languages">
                                                <path d="m5 8 6 6" />
                                                <path d="m4 14 6-6 2-3" />
                                                <path d="M2 5h12" />
                                                <path d="M7 2h1" />
                                                <path d="m22 22-5-10-5 10" />
                                                <path d="M14 18h6" />
                                            </svg>
                                        </a>
                                    @endcan

                                    @can('edit language')
                                        <a href="javascript:void(0)"
                                            x-on:click="$dispatch('open-language-edit', @js($language))"
                                            class="flex items-center justify-center text-xs
                                            hover:text-green-500 hover:bg-gray-200/25
                                            hover:rounded-md p-1.5 transition duration-200 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-square-pen">
                                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path
                                                    d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                            </svg>
                                        </a>
                                    @endcan





                                    @can('delete language')
                                        {{-- زر الحذف --}}
                                        <a href="javascript:void(0)" wire:click="delete('{{ $language->id }}')"
                                            class="flex items-center justify-center text-xs
                                            hover:text-red-500 hover:bg-gray-200/25 hover:rounded-md
                                            p-1.5 transition-[color,background-color,border-radius] duration-200 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-trash-icon lucide-trash">
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </a>
                                    @endcan


                                </div>
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
        </div>

        {{ $languages->links() }}

    </div>
</div>
