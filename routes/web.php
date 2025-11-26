<?php

use App\Livewire\Languages\LanguageIndex;
use App\Livewire\Permissions\PermissionsCreate;
use App\Livewire\Permissions\PermissionsEdit;
use Livewire\Volt\Volt;
use App\Livewire\Roles\Index;
use App\Livewire\Roles\Create;
use App\Livewire\Roles\EditRole;
use Illuminate\Support\Facades\Route;
use App\Livewire\Permissions\PermissionsIndex;
use App\Livewire\Users\UserCreate;
use App\Livewire\Users\UserEdit;
use App\Livewire\Users\UsersIndex;
use App\Livewire\Users\UserShow;
use App\Livewire\Logs\LogsPage;
use App\Livewire\Translations\TranslationsManager;
use App\Models\Translation;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'statusCheck'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Volt::route('settings/languages', 'settings.languages')->name('settings.languages');

    // roles & permissions routes
    Route::get('roles', Index::class)->name('roles.index');
    Route::get('roles/create', Create::class)->name('roles.create');
    Route::get('roles/edit/{role}', EditRole::class)->name('roles.edit');

    Route::get('permissions', PermissionsIndex::class)->name('permissions.index');
    Route::get('permissions/create', PermissionsCreate::class)->name('permissions.create');
    Route::get('permissions/edit/{permission}', PermissionsEdit::class)->name('permissions.edit');
    // end roles & permissions routes

    // users routes
    Route::get('users', UsersIndex::class)->name('users.index');
    Route::get('users/create', UserCreate::class)->name('users.create');
    Route::get('users/show/{user}', UserShow::class)->name('users.show');
    Route::get('users/edit/{user}', UserEdit::class)->name('users.edit');

    // Activity Logs Routes
    Route::get('activity-logs', LogsPage::class)->name('activity-logs.index');


    // language routes
    Route::get('languages', LanguageIndex::class)->name('languages.index');

    // Translation Routes
    Route::get('languages/{locale}/translations', TranslationsManager::class)->name('translations.index');
});

require __DIR__ . '/auth.php';
