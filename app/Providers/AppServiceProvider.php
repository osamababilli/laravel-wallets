<?php

namespace App\Providers;

use App\Policies\LogsPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Activity::class, LogsPolicy::class);

        $defaultLang = cache()->remember('default_language', 3600, function () {
            return Language::where('is_default', true)->value('code') ?? 'en';
        });

        App::setLocale($defaultLang);
    }
}
