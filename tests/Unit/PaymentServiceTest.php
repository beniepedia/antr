<?php

use App\Models\Tenant;
use App\Models\Plan;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use AdityaDarma\LaravelDuitku\Facades\DuitkuPOP;

// Gunakan RefreshDatabase agar DB bersih setiap test
uses(RefreshDatabase::class);



/**
 * Test gagal: Duitku tidak mengembalikan reference
 */
it('rollbacks and logs error when Duitku API returns no reference', function () {
    $this->seed(\Database\Seeders\PlansSeeder::class);

    // 🔹 Dummy data
    $tenant = Tenant::factory()->create();
    $plan = Plan::first();
    $paymentMethod = 'VC';
    $finalAmount = 100000;
    $fullName = 'John Doe';
    $email = 'john@example.com';
    $phone = '08123456789';

    // 🔹 Mock facade DuitkuPOP agar tidak panggil API beneran
    DuitkuPOP::shouldReceive('createTransaction')
        ->once()
        ->andReturn((object) []); // Tidak ada reference → gagal

    $service = app(PaymentService::class);
    $trx = $service->createPayment($tenant, $plan, $finalAmount, $fullName, $email, $phone, $paymentMethod);

    // 🔹 Pastikan transaksi gagal dan tidak tersimpan
    expect($trx)->toBeNull()
        ->and(Transaction::count())->toBe(0);


});

/**
 * Test gagal: Duitku throw exception saat createTransaction
 */
it('marks transaction as failed when DuitkuPOP throws exception', function () {
    $this->seed(\Database\Seeders\PlansSeeder::class);

    $tenant = Tenant::factory()->create();
    $plan = Plan::first();
    $paymentMethod = 'VC';
    $finalAmount = 200000;
    $fullName = 'Jane Doe';
    $email = 'jane@example.com';
    $phone = '08123456780';

    // 🔹 Mock DuitkuPOP supaya lempar exception
    DuitkuPOP::shouldReceive('createTransaction')
        ->once()
        ->andThrow(new Exception('API Timeout'));

    $service = app(PaymentService::class);
    $trx = $service->createPayment($tenant, $plan, $finalAmount, $fullName, $email, $phone, $paymentMethod);

    // 🔹 Karena rollback, transaksi tidak tersimpan
    expect($trx)->toBeNull()
        ->and(Transaction::count())->toBe(0);


});

/**
 * Test transaksi berhasil dibuat
 */
it('creates transaction successfully when Duitku returns reference', function () {
    $this->seed(\Database\Seeders\PlansSeeder::class);

    $tenant = Tenant::factory()->create();
    $plan = Plan::first();
    $paymentMethod = 'VC';
    $finalAmount = 150000;
    $fullName = 'Success User';
    $email = 'success@example.com';
    $phone = '08123456789';

    // 🔹 Mock DuitkuPOP untuk return reference
    DuitkuPOP::shouldReceive('createTransaction')
        ->once()
        ->andReturn((object) [
            'reference' => 'REF123456',
            'paymentUrl' => 'https://duitku.com/pay/REF123456',
        ]);

    $service = app(PaymentService::class);
    $trx = $service->createPayment($tenant, $plan, $finalAmount, $fullName, $email, $phone, $paymentMethod);

    // 🔹 Pastikan transaksi berhasil dibuat
    expect($trx)->not->toBeNull()
        ->and($trx->status)->toBe('pending')
        ->and($trx->payment_ref)->toBe('REF123456')
        ->and($trx->total)->toBe($finalAmount)
        ->and(Transaction::count())->toBe(1);
});
