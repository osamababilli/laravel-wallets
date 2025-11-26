<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>

        {{-- @if (session()->has('success'))
            {{ session('success') }} }}
            <script>
                require('sweetalert2/dist/sweetalert2.min.css');
                document.addEventListener('DOMContentLoaded', function() {
                    const toast = @json(session('success'));
                    // مثال باستخدام SweetAlert2 مع شريط الوقت
                    Swal.fire({
                        icon: toast.type,
                        text: toast.message,

                    });
                });
            </script>
        @endif --}}

        <livewire:notification />

        {{-- @filamentStyles
        @filamentScripts --}}

        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
