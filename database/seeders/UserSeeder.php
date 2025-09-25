<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    }
}
