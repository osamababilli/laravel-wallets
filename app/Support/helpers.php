<?php

use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

if (! function_exists('notify')) {
    /**
     * دالة إشعارات موحدة وبسيطة
     *
     * @param string $message رسالة الإشعار
     * @param string $type نوع الإشعار (success, error, warning, info)
     * @param bool $redirect هل تريد الإشعار يظهر بعد redirect
     */
    function notify(string $message, string $type = 'success', bool $redirect = true)
    {
        if ($redirect) {
            // إذا تريد الإشعار يظهر بعد redirect
            session()->flash('saved', [
                'title' => $message,

            ]);
            return;
        }


        // استخدام نوع الإشعار المطلوب بطريقة أبسط
        $validTypes = ['success', 'error', 'warning', 'info'];
        $alertType = in_array($type, $validTypes) ? $type : 'success';

        LivewireAlert::title($message)
            ->{$alertType}()
            ->show();
    }

    function confermeDelete($component, $title, $message,  $itemId)
    {

        $component->dispatch('delete-confirm', ['id' => $itemId, 'message' => $message, 'title' => $title]);
    }
}
