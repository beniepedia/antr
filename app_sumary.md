1 — Pastikan auth.php (singkat)

Pastikan config/auth.php punya guard/provider seperti ini (sudah pernah kita bahas, tapi cek lagi):

'guards' => [
'web' => [
'driver' => 'session',
'provider' => 'users',
],
'admin' => [
'driver' => 'session',
'provider' => 'admins',
],
],

'providers' => [
'users' => [
'driver' => 'eloquent',
'model' => App\Models\User::class,
],
'admins' => [
'driver' => 'eloquent',
'model' => App\Models\Admin::class,
],
],

2 — Buat Livewire components

Jalankan:

php artisan make:livewire Auth/Login # untuk tenant user
php artisan make:livewire Admin/Login # untuk superadmin

(Ini akan menghasilkan kelas dan view: app/Http/Livewire/Auth/Login.php + resources/views/livewire/auth/login.blade.php, dan app/Http/Livewire/Admin/Login.php + view admin.)

3 — Kode Livewire: Tenant Login (Auth/Login.php)

Letakkan di app/Http/Livewire/Auth/Login.php:

<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ];

    public function mount()
    {
        if (Auth::guard('web')->check()) {
            redirect()->route('tenant.dashboard');
        }
    }

    public function login()
    {
        $this->validate();

        $key = 'login:'.Str::lower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");
            return;
        }

        if (Auth::guard('web')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($key);
            session()->regenerate();
            return redirect()->intended(route('tenant.dashboard'));
        }

        RateLimiter::hit($key, 60);
        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.user');
    }
}

4 — View Livewire: Tenant Login (resources/views/livewire/auth/login.blade.php)

Contoh minimal pakai Tailwind (sesuaikan UI-mu / template admin):

<div class="max-w-md mx-auto mt-16 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">Masuk</h2>

    <form wire:submit.prevent="login" novalidate>
        <div class="mb-4">
            <label class="block text-sm">Email</label>
            <input wire:model.defer="email" type="email" class="w-full border rounded px-3 py-2" />
            @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm">Password</label>
            <input wire:model.defer="password" type="password" class="w-full border rounded px-3 py-2" />
            @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4 flex items-center">
            <input wire:model="remember" id="remember" type="checkbox" class="mr-2" />
            <label for="remember" class="text-sm">Ingat saya</label>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Masuk</button>
            <a href="{{ route('password.request') }}" class="text-sm text-gray-600">Lupa password?</a>
        </div>
    </form>
</div>

5 — Kode Livewire: Admin Login (app/Http/Livewire/Admin/Login.php)

Hampir sama, tapi pakai guard admin dan layout admin:

<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ];

    public function mount()
    {
        if (Auth::guard('admin')->check()) {
            redirect()->route('admin.dashboard');
        }
    }

    public function login()
    {
        $this->validate();

        $key = 'admin-login:'.Str::lower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");
            return;
        }

        if (Auth::guard('admin')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($key);
            session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($key, 60);
        $this->addError('email', 'Email atau password admin salah.');
    }

    public function render()
    {
        return view('livewire.admin.login')->layout('layouts.admin');
    }
}


Buat view resources/views/livewire/admin/login.blade.php mirip view tenant, tapi layout layouts.admin.

6 — Routes (web.php)

Tambahkan route ke routes/web.php:

use App\Http\Livewire\Auth\Login as UserLogin;
use App\Http\Livewire\Admin\Login as AdminLogin;

// guest for tenant users
Route::middleware('guest:web')->group(function () {
    Route::get('/login', UserLogin::class)->name('login');
    // Route::get('/register', RegisterComponent::class)->name('register'); // jika ada
});

// admin guest
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/login', AdminLogin::class)->name('admin.login');
});


Untuk dashboard routes, bungkus dengan middleware auth:

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', \App\Http\Controllers\Tenant\DashboardController::class)->name('tenant.dashboard');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', \App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');
});

7 — Logout (routes + snippet)

Tambahkan route logout (POST):

use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::guard('web')->logout();
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
