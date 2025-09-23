<?php

use App\Livewire\Admin\Login as AdminLogin;
use App\Livewire\Auth\Login as UserLogin;
use App\Livewire\Auth\Register as UserRegister;
use App\Livewire\Tenant\Dashboard;
use App\Livewire\Tenant\Petugas;
use App\Livewire\Tenant\Setup;
use App\Livewire\Tenant\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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
    Route::get('/petugas', Petugas::class)->name('tenant.petugas');
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
Route::post('/logout', function () {
    Auth::guard('tenant')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::post('/admin/logout', function () {
    Auth::guard('admin')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('admin.login');
})->name('admin.logout');

Route::get('/components', function () {
    return view('components.flyonui-components');
})->name('components');
