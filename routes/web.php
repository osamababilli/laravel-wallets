<?php

use App\Livewire\Dashboard\Dashboard;
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
use App\Livewire\Plans\PlansCreate;
use App\Livewire\Plans\PlansList;
use App\Livewire\Plans\UsersPlans\PlansList as UsersPlansPlansList;
use App\Livewire\Translations\TranslationsManager;
use App\Livewire\Wallets\ReciversWallets;
use App\Livewire\Wallets\Transactions\TransactionsIndex;
use App\Models\Translation;
use App\Livewire\Plans\UsersPlans\MyInvestments;
use App\Livewire\Members\MembersList;
use App\Livewire\Members\ProfitWithdrawals\ProfitWithdrawalsList;
use App\Livewire\DepositPage;
use App\Livewire\WithdrawPage;



Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', Dashboard::class)->name('dashboard');


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

    // transactions routes

    Route::get('transactions', TransactionsIndex::class)->name('transactions.index');
    // end transactions routes
    // wallet requests routes
    Route::get('wallet-requests', \App\Livewire\Wallets\WalletsRequests::class)->name('wallet-requests.index');
    Route::get('withdraw-requests', \App\Livewire\Wallets\WithdrawRequests::class)->name('withdraw-requests.index');
    // end wallet requests routes

    Route::get('crypto-wallet', ReciversWallets::class)->name('crypto-wallet.index');



    // Plans routes
    Route::get('plans', PlansList::class)->name('plans.index');



    // Users Plans routes
    Route::get('view-plans', UsersPlansPlansList::class)->name('users.plans.index');

    // Users inverstments
    Route::get('my-investments', MyInvestments::class)->name('users.investments.index');


    // Members routes
    Route::get('members', MembersList::class)->name('members.index');




    //investments  ProfitWithdrawal  routes
    Route::get('profit-withdrawals', ProfitWithdrawalsList::class)->name('profit-withdrawals.index');


    // Activity Logs Routes
    Route::get('activity-logs', LogsPage::class)->name('activity-logs.index');



    // deposit page
    Route::get('deposit-page', DepositPage::class)->name('deposit-page.index');
    Route::get('deposit-page/{wallet}', \App\Livewire\DepositDetails::class)->name('deposit-page.details');

    // withdraw page
    Route::get('withdraw-page', WithdrawPage::class)->name('withdraw-page.index');


    // language routes
    Route::get('languages', LanguageIndex::class)->name('languages.index');

    // Translation Routes
    Route::get('languages/{locale}/translations', TranslationsManager::class)->name('translations.index');
});

require __DIR__ . '/auth.php';
