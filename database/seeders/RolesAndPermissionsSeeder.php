<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // buat permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create users']);

        // buat roles dan beri permissions
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo(['view users','edit users','delete users','create users']);

        $roleUser = Role::create(['name' => 'user']);
        $roleUser->givePermissionTo(['view users']);

        // bisa juga assign role ke user awal
        $user = \App\Models\User::find(1);
        if($user) {
            $user->assignRole('admin');
        }
    }
}
