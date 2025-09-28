<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'tenant_id' => 1, // SPBU001
                'type' => 'sedan roda 2',
                'max_liters' => 50,
            ],
            [
                'tenant_id' => 1,
                'type' => 'SUV',
                'max_liters' => 60,
            ],
            [
                'tenant_id' => 2, // SPBU002
                'type' => 'motor',
                'max_liters' => 10,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}