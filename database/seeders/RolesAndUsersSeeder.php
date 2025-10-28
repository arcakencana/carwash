<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // === PERMISSIONS ===
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // === ROLES ===
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        // Beri semua permission ke admin
        $adminRole->syncPermissions(Permission::all());

        // User role hanya bisa view
        $userRole->syncPermissions(['view users']);

        // === USERS ===
        // ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'), // password default
            ]
        );
        $admin->assignRole($adminRole);

        // USER
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('user123'), // password default
            ]
        );
        $user->assignRole($userRole);

        $this->command->info('✅ Seeder selesai! Admin & User berhasil dibuat.');
        $this->command->info('Admin login: admin@example.com / admin123');
        $this->command->info('User login: user@example.com / user123');
    }
}
