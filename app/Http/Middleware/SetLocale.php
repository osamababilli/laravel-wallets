<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {

        // dd(session('locale'));
        // إذا في لغة محفوظة بالجلسة
        if (session()->has('locale')) {
            App::setLocale(session('locale'));
        } else {
            // إذا ما في، استخدم اللغة الافتراضية
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
