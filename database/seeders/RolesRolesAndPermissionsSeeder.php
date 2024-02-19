<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'read']);
        Permission::create(['name' => 'update']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'export']);
        Permission::create(['name' => 'keranjang']);
        Permission::create(['name' => 'transaksi']);
        Permission::create(['name' => 'payment']);
        Permission::create(['name' => 'verifikasi']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'owner']);
        $role->givePermissionTo('read', 'export');

        // or may be done by chaining
        $role = Role::create(['name' => 'pelanggan'])
            ->givePermissionTo(['keranjang', 'transaksi', 'payment']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
