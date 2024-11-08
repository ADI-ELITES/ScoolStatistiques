<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::find(1);

        $permissions = Permission::all();

        $role->syncPermissions($permissions);
        /*foreach ($permissions as $p) {
            $role->assignedPermissions([$p]);
        }*/
    }
}
