<!-- ضع هذا في layout أو في أي صفحة تريد عرض الإشعارات فيها -->
<div></div>

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // عرض الإشعار من الجلسة
        @if (session()->has('notify'))
            const notification = @json(session('notify'));
            showNotification(notification.message, notification.type);
        @endif
    });

    // دالة عرض الإشعار الموحدة
    function showNotification(message, type, timeout = 3000) {
        // تحديد نوع الأيقونة والألوان
        let icon = 'info';
        let iconColor = '#3b82f6';

        if (type === 'success') {
            icon = 'success';
            iconColor = '#10b981';
        } else if (type === 'error') {
            icon = 'error';
            iconColor = '#ef4444';
        } else if (type === 'warning') {
            icon = 'warning';
            iconColor = '#f59e0b';
        }

        const isDark = document.documentElement.classList.contains("dark");

        Swal.fire({
            icon: icon,
            text: message,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: timeout,
            width: "auto",
            padding: "1rem",
            background: isDark ? '#1f2937' : '#ffffff',
            color: isDark ? '#f9fafb' : '#111827',
            iconColor: iconColor,
            timerProgressBar: true,
            showClass: {
                popup: 'animate__animated animate__slideInRight animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__slideOutRight animate__faster'
            },
            customClass: {
                popup: 'text-sm rounded-lg shadow-xl border ' + (isDark ? 'border-gray-700' :
                    'border-gray-200'),
                title: 'text-sm font-medium',
                content: 'text-sm',
                icon: 'border-0'
            },
            didOpen: (toast) => {
                // إضافة تأثيرات hover
                toast.addEventListener('mouseenter', () => Swal.stopTimer());
                toast.addEventListener('mouseleave', () => Swal.resumeTimer());
            }
        });
    }

    // للاستماع للأحداث من Livewire أو JavaScript
    document.addEventListener('show-notify', function(event) {
        const {
            message,
            type,
            timeout
        } = event.detail;
        showNotification(message, type, timeout);
    });

    // دالة مساعدة لاستدعاء الإشعارات من JavaScript
    window.notify = function(message, type = 'success', timeout = 3000) {
        showNotification(message, type, timeout);
    };
</script><!-- ضع هذا في layout أو في أي صفحة تريد عرض الإشعارات فيها -->
<div id="notifications-container"></div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // عرض الإشعارات من الجلسة (بعد تحميل الصفحة أو redirect)
    document.addEventListener('DOMContentLoaded', function() {
        @if (session()->has('notifications'))
            const notifications = @json(session('notifications'));

            // عرض كل إشعار
            notifications.forEach(function(notification, index) {
                setTimeout(function() {
                    showNotification(notification.message, notification.type, notification
                        .timeout);
                }, index * 200); // تأخير بسيط بين الإشعارات المتعددة
            });
        @endif

        // مسح الإشعارات من الجلسة بعد العرض
        @if (session()->has('notifications'))
            session() - > forget('notifications');
        @endif
    });

    // الاستماع للأحداث الفورية (بدون redirect)
    document.addEventListener('show-notify', function(event) {
        const {
            message,
            type,
            timeout
        } = event.detail;
        showNotification(message, type, timeout);
    });

    // دالة عرض الإشعار الموحدة
    function showNotification(message, type, timeout = 3000) {
        // تحديد نوع الأيقونة
        let icon = 'info';
        if (type === 'success') icon = 'success';
        else if (type === 'error') icon = 'error';
        else if (type === 'warning') icon = 'warning';

        const isDark = document.documentElement.classList.contains("dark");

        Swal.fire({
            icon: icon,
            text: message,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: timeout,
            width: "auto",
            padding: "0.8rem",
            background: isDark ? '#374151' : '#ffffff',
            color: isDark ? '#f9fafb' : '#111827',
            timerProgressBar: true,
            customClass: {
                popup: 'text-sm rounded-lg shadow-lg border',
                title: 'text-sm font-medium',
                content: 'text-xs'
            },
            didOpen: (toast) => {
                // تأثيرات إضافية عند الفتح
                toast.style.transform = 'translateX(0)';
                toast.style.opacity = '1';
            }
        });
    }
</script> --}}
