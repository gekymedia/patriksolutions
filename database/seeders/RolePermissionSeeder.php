<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage users',
            'manage blogs',
            'manage courses',
            'manage contacts',
            'send notifications',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign basic permissions to user
        $userRole->givePermissionTo(['view dashboard']);

        // Assign admin role to existing admin users
        $adminUsers = User::where('role', 'admin')->get();
        foreach ($adminUsers as $user) {
            if (!$user->hasRole('admin')) {
                $user->assignRole('admin');
            }
        }

        // Assign user role to non-admin users
        $regularUsers = User::where('role', '!=', 'admin')->orWhereNull('role')->get();
        foreach ($regularUsers as $user) {
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }
        }

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
