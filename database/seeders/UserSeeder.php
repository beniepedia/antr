<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User untuk tenant Jakarta
        User::updateOrCreate(
            ['email' => 'admin@jakarta.test'],
            [
                'tenant_id' => 1,
                'name' => 'Admin Jakarta',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // User untuk tenant Bandung
        User::updateOrCreate(
            ['email' => 'admin@bandung.test'],
            [
                'tenant_id' => 2,
                'name' => 'Admin Bandung',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // User tanpa tenant (untuk setup)
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Setup',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create 20 petugas users for tenant Jakarta
        $this->createPetugasUsers(1, 'Jakarta');

        // Create 20 petugas users for tenant Bandung
        $this->createPetugasUsers(2, 'Bandung');
    }

    /**
     * Create petugas users for a specific tenant
     */
    private function createPetugasUsers($tenantId, $cityName)
    {
        $positions = ['operator', 'supervisor', 'manager'];
        $firstNames = [
            'Ahmad', 'Budi', 'Citra', 'Dedi', 'Eka', 'Fajar', 'Gita', 'Hadi', 'Indah', 'Joko',
            'Kartika', 'Lutfi', 'Maya', 'Nanda', 'Oka', 'Putri', 'Rudi', 'Sari', 'Tono', 'Umi',
        ];
        $lastNames = [
            'Santoso', 'Wijaya', 'Kusuma', 'Hartono', 'Susanto', 'Pratama', 'Saputra', 'Permana',
            'Ramadhan', 'Nugroho', 'Setiawan', 'Wibowo', 'Lestari', 'Firmansyah', 'Hidayat',
            'Suryadi', 'Kurniawan', 'Wahyudi', 'Purnama', 'Aditya',
        ];

        $addresses = [
            'Jl. Sudirman No. 123, '.$cityName,
            'Jl. Thamrin No. 456, '.$cityName,
            'Jl. Gajah Mada No. 789, '.$cityName,
            'Jl. Malioboro No. 321, '.$cityName,
            'Jl. Braga No. 654, '.$cityName,
            'Jl. Asia Afrika No. 987, '.$cityName,
            'Jl. Pahlawan No. 147, '.$cityName,
            'Jl. Diponegoro No. 258, '.$cityName,
            'Jl. Ahmad Yani No. 369, '.$cityName,
            'Jl. Veteran No. 741, '.$cityName,
        ];

        // Check if tenant exists
        $tenant = \App\Models\Tenant::find($tenantId);
        if (! $tenant) {
            $this->command->warn("Tenant with ID {$tenantId} not found. Skipping petugas creation for {$cityName}.");

            return;
        }

        for ($i = 1; $i <= 20; $i++) {
            // Use predefined names to avoid duplicates
            $firstName = $firstNames[($i - 1) % count($firstNames)];
            $lastName = $lastNames[($i - 1) % count($lastNames)];
            $fullName = $firstName.' '.$lastName;

            // Create unique email
            $email = strtolower($firstName.'.'.$lastName.'@'.strtolower($cityName).'.test');

            // If email exists, add number suffix
            $emailCounter = 1;
            $originalEmail = $email;
            while (User::where('email', $email)->exists()) {
                $email = str_replace('@', $emailCounter.'@', $originalEmail);
                $emailCounter++;
            }

            try {
                // Create user
                $user = User::create([
                    'tenant_id' => $tenantId,
                    'name' => $fullName,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'petugas',
                ]);

                // Create unique whatsapp number
                $whatsapp = '628'.str_pad($tenantId.$i, 9, '0', STR_PAD_LEFT);

                // Create profile
                Profile::create([
                    'user_id' => $user->id,
                    'tenant_id' => $tenantId,
                    'employee_id' => strtoupper(substr($cityName, 0, 1)).str_pad($i, 3, '0', STR_PAD_LEFT),
                    'position' => $positions[array_rand($positions)],
                    'hire_date' => Carbon::now()->subDays(rand(30, 1095)), // Random date within last 3 years
                    'status' => rand(0, 9) < 8 ? 'active' : 'inactive', // 80% active, 20% inactive
                    'license_number' => 'LIS'.strtoupper(substr($cityName, 0, 1)).str_pad($i, 4, '0', STR_PAD_LEFT),
                    'experience_years' => rand(1, 15),
                    'whatsapp' => $whatsapp,
                    'address' => $addresses[array_rand($addresses)],
                ]);

                $this->command->info("Created petugas: {$fullName} ({$email})");

            } catch (\Exception $e) {
                $this->command->error("Failed to create petugas {$fullName}: ".$e->getMessage());
            }
        }
    }
}
