<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'code' => 'SPBU001',
            'name' => 'SPBU Pertamina Jakarta',
            'address' => 'Jl. Sudirman No. 1, Jakarta',
            'phone' => '021-1234567',
            'whatsapp' => '6281234567890',
            'url' => 'jakarta',
            'max_queue_time' => '12:00',
            'status' => 1,
        ]);

        Tenant::create([
            'code' => 'SPBU002',
            'name' => 'SPBU Pertamina Bandung',
            'address' => 'Jl. Asia Afrika No. 2, Bandung',
            'phone' => '022-9876543',
            'whatsapp' => '6289876543210',
            'url' => 'bandung',
            'max_queue_time' => '11:00',
            'status' => 1,
        ]);
    }
}
