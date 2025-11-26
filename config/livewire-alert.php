<?php

use Jantinnerezo\LivewireAlert\Enums\Position;
use Illuminate\Support\Js;

return [
    'position' => Position::TopEnd,
    'timer' => 2000,
    'toast' => true,
    'text' => null,
    'timerProgressBar' => true,
    'width' => 'auto',
    'closeButton' => true,
    'heightAuto' => true,
    'padding' => '1rem',
    // 'theme' => new Js(
    //     '() => {
    //         const isDark = document.documentElement.classList.contains("dark");
    //         return isDark ? "dark" : "light";
    //     }'
    // ),
    'theme' => 'auto',
    'confirmButtonText' => 'Yes',
    'cancelButtonText' => 'Cancel',
    'denyButtonText' => 'No',
    'showCancelButton' => false,
    'showConfirmButton' => false,
    'backdrop' => true,

];
