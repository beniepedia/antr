<?php

use App\Livewire\Admin\Login as AdminLogin;
use App\Livewire\Auth\Login as UserLogin;
use App\Livewire\Auth\Register as UserRegister;
use App\Livewire\Customer\Auth\Login as CustomerLogin;
use App\Livewire\Customer\Dashboard as CustomerDashboard;
use App\Livewire\Customer\Queues\Create as CustomerQueueCreate;
use App\Livewire\Customer\Queues\Index as CustomerQueueIndex;
use App\Livewire\Tenant\Dashboard;
use App\Livewire\Tenant\Karyawan\KaryawanCreate;
use App\Livewire\Tenant\Karyawan\KaryawanEdit;
use App\Livewire\Tenant\Karyawan\KaryawanIndex;
use App\Livewire\Tenant\Karyawan\KaryawanShow;
use App\Livewire\Tenant\Payment;
use App\Livewire\Tenant\queue\QueueIndex;
use App\Livewire\Tenant\Settings as TenantSettings;
use App\Livewire\Tenant\Setup;
use App\Livewire\Tenant\Subscription;
use App\Livewire\Tenant\Upgrade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::domain('{subdomain:url}.'.config('app.url'))
    ->middleware('tenant.domain')
    ->group(function () {
        // Customer Portal (public and authenticated)
        Route::get('/login', CustomerLogin::class)->middleware('guest:customer')->name('customer.login');

        Route::middleware('auth:customer')->group(function () {
            Route::get('/dashboard', CustomerDashboard::class)->name('customer.dashboard');
            Route::get('/queues', CustomerQueueIndex::class)->name('customer.queues');
            Route::get('/queues/create', CustomerQueueCreate::class)->name('customer.queues.create');

            Route::post('/logout', function () {
                Auth::guard('customer')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                return redirect()->route('customer.login')->header('X-Livewire-Navigate', 'true');
            })->name('customer.logout');
        });
    });

// guest for tenant users
Route::middleware('guest:tenant')->group(function () {
    Route::get('/login', UserLogin::class)->name('login');
    Route::get('/register', UserRegister::class)->name('register');
});

// admin guest
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/login', AdminLogin::class)->name('admin.login');
});

// For dashboard routes, bungkus with middleware auth:
Route::middleware(['auth:tenant', 'tenant.active'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('tenant.dashboard');

    Route::get('/antrian', QueueIndex::class)->name('tenant.antrian');

    Route::get('/karyawan', KaryawanIndex::class)->name('tenant.karyawan');
    Route::get('/karyawan/create', KaryawanCreate::class)->name('tenant.karyawan.create');
    Route::get('/karyawan/{id}/show', KaryawanShow::class)->name('tenant.karyawan.show');
    Route::get('/karyawan/{id}/edit', KaryawanEdit::class)->name('tenant.karyawan.edit');

    Route::get('/settings', TenantSettings::class)->name('tenant.settings');

    Route::get('/tenant/upgrade', Upgrade::class)->name('tenant.upgrade');
    Route::get('/tenant/payment/{plan}', Payment::class)->name('tenant.subscription.payment');

    Route::post('/logout', function () {
        Auth::guard('tenant')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->header('X-Livewire-Navigate', 'true');
    })->name('tenant.logout');

});

Route::middleware(['auth:tenant'])->group(function () {
    Route::get('/onboarding', Setup::class)->name('tenant.onboarding');
    Route::get('/subscription', Subscription::class)->name('tenant.subscription');
});

// Route::prefix('admin')->middleware('auth:admin')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');
// });

// Logout routes

Route::post('/admin/logout', function () {
    Auth::guard('admin')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('admin.login');
})->name('admin.logout');

Route::get('/components', function () {
    return view('components.flyonui-components');
})->name('components');
