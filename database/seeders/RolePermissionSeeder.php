<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage users',
            'view users',

            'manage items',
            'view items',
            'manage sales',
            'view sales',
            'manage payments',
            'view payments',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $cashier = Role::firstOrCreate(['name' => 'cashier']);

        // Admin: all permissions
        $admin->syncPermissions(Permission::all());

        // Cashier: everything except users
        $cashier->syncPermissions([
            'manage items',
            'view items',
            'manage sales',
            'view sales',
            'manage payments',
            'view payments',
        ]);
    }
}
