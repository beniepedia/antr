<?php

namespace Database\Seeders;

use App\Models\Pump;
use Illuminate\Database\Seeder;

class PumpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pumps = [
            [
                'tenant_id' => 1,
                'name' => 'Pompa A',
            ],
            [
                'tenant_id' => 1,
                'name' => 'Pompa B',
            ],
            [
                'tenant_id' => 1,
                'name' => 'Pompa C',
            ],
        ];

        Pump::insert($pumps);
    }
}
