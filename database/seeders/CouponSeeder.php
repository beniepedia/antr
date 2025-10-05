<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel coupons.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'DISKON20',
                'description' => 'Diskon 20% untuk semua paket.',
                'discount_type' => 'percent',
                'discount_value' => 20,
                'max_uses' => 500,
                'used_count' => 0,
                'per_user_limit' => 1,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'plan_id' => null, // berlaku untuk semua plan
                'is_active' => true,
            ],
            [
                'code' => 'WELCOME10',
                'description' => 'Diskon 10% untuk pengguna baru.',
                'discount_type' => 'percent',
                'discount_value' => 10,
                'max_uses' => null,
                'used_count' => 0,
                'per_user_limit' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'plan_id' => null,
                'is_active' => true,
            ],
            [
                'code' => 'TRIAL5',
                'description' => 'Potongan Rp5.000 untuk langganan pertama.',
                'discount_type' => 'fixed',
                'discount_value' => 5000,
                'max_uses' => 200,
                'used_count' => 0,
                'per_user_limit' => 1,
                'start_date' => now(),
                'end_date' => now()->addDays(14),
                'plan_id' => null,
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $data) {
            Coupon::updateOrCreate(['code' => $data['code']], $data);
        }

        $this->command->info('✅ CouponSeeder berhasil dijalankan! Kupon global sudah ditambahkan.');
    }
}
