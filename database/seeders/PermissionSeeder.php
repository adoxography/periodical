<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'have bio']);

        Permission::create(['name' => 'show bio on homepage']);
        Permission::create(['name' => 'alter site settings']);

        Role::create(['name' => 'contributor'])
            ->givePermissionTo([
                'create posts',
                'have bio'
            ]);

        Role::create(['name' => 'administrator'])
            ->givePermissionTo([
                'show bio on homepage',
                'alter site settings'
            ]);
    }
}
