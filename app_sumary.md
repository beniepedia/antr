Laravel 12, Livewire 3, FlyOnui

Flow dengan Livewire

Akses Subdomain

tenant1.antrian.test → middleware tenant.domain resolve tenant.

Login WA + OTP

tenant1.antrian.test/login → Livewire component Customer\Auth\Login.

Input nomor WA → generate OTP → kirim ke WA → tampilkan input OTP.

Submit OTP → validasi → simpan session guard customer.

Dashboard Customer

tenant1.antrian.test/dashboard → Livewire component Customer\Dashboard.

Dari sini bisa akses antrean:

Lihat nomor antrean aktif.

Ambil tiket baru (jika belum ada).

Lihat riwayat antrean.

📂 Struktur Folder Livewire
app/Livewire/Customer/
├─ Auth/
│ ├─ Login.php (nomor WA + OTP)
│ └─ VerifyOtp.php (opsional, bisa digabung)
├─ Dashboard.php
└─ Queues/
├─ Index.php (daftar antrean customer)
└─ Create.php (ambil tiket antrean baru)

Views Livewire khusus Customer → resources/views/livewire/customer/:

resources/views/livewire/customer/
├─ auth/
│ └─ login.blade.php
├─ dashboard.blade.php
└─ queues/
├─ index.blade.php
└─ create.blade.php

⚡ Routing

Tetap definisi pakai Route::domain, tapi arahkan ke Livewire Component, bukan controller:

use App\Livewire\Customer\Auth\Login;
use App\Livewire\Customer\Dashboard;
use App\Livewire\Customer\Queues\Index as QueueIndex;
use App\Livewire\Customer\Queues\Create as QueueCreate;

Route::domain('{tenant:url}.' . config('app.url'))
->middleware('tenant.domain')
->group(function () {

        // Login Customer
        Route::get('/login', Login::class)->name('customer.login');

        // Dashboard & antrean (hanya jika sudah login)
        Route::middleware('auth:customer')->group(function () {
            Route::get('/dashboard', Dashboard::class)->name('customer.dashboard');
            Route::get('/queues', QueueIndex::class)->name('customer.queues');
            Route::get('/queues/create', QueueCreate::class)->name('customer.queues.create');
        });
    });

🎨 Layout Khusus Customer

Biar nggak campur dengan admin/staff, bikin layout terpisah:

resources/views/layouts/customer.blade.php

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Customer Portal - {{ $tenant->name ?? 'Antrian' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans">

    <header class="bg-white shadow p-4">
        <h1 class="text-xl font-bold">{{ $tenant->name ?? 'Antrian' }}</h1>
    </header>

    <main class="container mx-auto mt-6">
        {{ $slot }}
    </main>

    @livewireScripts

</body>
</html>

Lalu di setiap component kamu bisa extend layout ini:

<x-layouts.customer>

<h2 class="text-lg font-semibold">Dashboard Customer</h2>
...
</x-layouts.customer>

🔥 Jadi ringkasannya:

Controller → ganti dengan Livewire Component.

Struktur rapi di folder app/Livewire/Customer.

Routing tetap bisa pakai Route::domain dengan pointing langsung ke component.

Layout dipisah, jadi portal customer beda feel dari admin/staff.
