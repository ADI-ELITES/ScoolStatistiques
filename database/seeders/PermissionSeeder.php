<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            'users',
            'notes',
            'classes',
            'eleves',
            'add_notes',
        ];

        foreach ($permission as $p) {
            \Spatie\Permission\Models\Permission::create(['name' => $p]);
        }
    }
}
