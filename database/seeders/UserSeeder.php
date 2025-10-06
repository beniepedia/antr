<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Faker\Factory as Faker;
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
                'name' => 'Petugas A',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // User untuk tenant Bandung
        User::updateOrCreate(
            ['email' => 'admin1@jakarta.test'],
            [
                'tenant_id' => 1,
                'name' => 'Petugas B',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

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
        $faker = Faker::create('id_ID'); // Use Indonesian locale for Faker
        $positions = ['operator', 'supervisor', 'manager'];

        // Check if tenant exists
        $tenant = \App\Models\Tenant::find($tenantId);
        if (! $tenant) {
            $this->command->warn("Tenant with ID {$tenantId} not found. Skipping petugas creation for {$cityName}.");

            return;
        }

        for ($i = 1; $i <= 20; $i++) {
            $fullName = $faker->name();

            // Create unique email
            $email = $faker->unique()->userName().'@'.strtolower($cityName).'.test';

            try {
                // Create user
                $user = User::create([
                    'tenant_id' => $tenantId,
                    'name' => $fullName,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'petugas',
                ]);

                // Create profile
                Profile::create([
                    'user_id' => $user->id,
                    'employee_id' => strtoupper(substr($cityName, 0, 1)).str_pad($i, 3, '0', STR_PAD_LEFT),
                    'position' => $faker->randomElement($positions),
                    'hire_date' => $faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
                    'status' => $faker->boolean(80) ? 'active' : 'inactive', // 80% active
                    'license_number' => 'LIS'.strtoupper(substr($cityName, 0, 1)).str_pad($i, 4, '0', STR_PAD_LEFT),
                    'whatsapp' => '628'.$faker->numerify('#########'),
                    'address' => $faker->address(),
                ]);

                $this->command->info("Created petugas: {$fullName} ({$email})");

            } catch (\Exception $e) {
                $this->command->error("Failed to create petugas {$fullName}: ".$e->getMessage());
            }
        }
    }
}
