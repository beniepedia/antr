<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'slug' => 'free',
                'price' => 0.00,
                'description' => 'Trial gratis selama 10 hari untuk mencoba fitur dasar.',
                'billing_cycle' => 'trial',
                'duration_days' => 10,
                'features' => [
                    'Akses dasar sistem antrian',
                    'Maksimal 1 SPBU',
                    'Support email',
                    '10 hari gratis',
                ],
                'is_trial' => 1,
            ],
            [
                'name' => 'Bulanan',
                'slug' => 'bulanan',
                'price' => 50000.00,
                'description' => 'Langganan bulanan dengan akses penuh fitur.',
                'billing_cycle' => 'monthly',
                'duration_days' => 30,
                'features' => [
                    'Akses penuh sistem antrian',
                    'Maksimal 5 SPBU',
                    'Support email dan chat',
                    'Laporan harian',
                    'Update otomatis',
                ],
            ],
            [
                'name' => 'Tahunan',
                'slug' => 'tahunan',
                'price' => 500000.00,
                'description' => 'Langganan tahunan dengan diskon dan prioritas support.',
                'billing_cycle' => 'yearly',
                'duration_days' => 365,
                'features' => [
                    'Akses penuh sistem antrian',
                    'SPBU unlimited',
                    'Prioritas support 24/7',
                    'Laporan advanced',
                    'API access',
                    'Diskon 20% dari bulanan',
                ],
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
