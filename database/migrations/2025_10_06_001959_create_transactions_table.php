<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();

            // Kode unik invoice internal
            $table->string('transaction_code')->unique();

            // Kode unik dari gateway (VA / QR / ref)
            $table->string('payment_ref')->nullable();

            // Informasi harga
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2);

            // Status transaksi
            $table->enum('status', [
                'pending',    // menunggu pembayaran
                'paid',       // berhasil dibayar
                'failed',     // gagal / ditolak gateway
                'expired',    // melewati batas waktu
                'cancelled'   // dibatalkan manual
            ])->default('pending');

            // Metode pembayaran
            $table->string('payment_method')->nullable(); // misal: duitku, midtrans, manual

            // Data waktu
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Metadata tambahan (VA number, QR URL, dsb)
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
