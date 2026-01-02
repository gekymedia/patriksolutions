<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolePermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call(RolePermissionSeeder::class);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@patriksolutions.com'],
            [
                'name' => 'Admin',
                'role' => 'admin',
                'password' => Hash::make('dev@patriksolutions'),
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role if not already assigned
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@patriksolutions.com'],
            [
                'name' => 'Test User',
                'role' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign user role if not already assigned
        if (!$user->hasRole('user')) {
            $user->assignRole('user');
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin: admin@patriksolutions.com / dev@patriksolutions');
        $this->command->info('User: user@patriksolutions.com / password');
    }
}
