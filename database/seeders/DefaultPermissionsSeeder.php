<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DefaultPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'group_name' => 'Manage Roles',
                'name' => 'manage_roles',
            ],
            [
                'group_name' => 'Manage Users',
                'name' => 'manage_users',
            ],
        ];

        foreach ($permissions as $permission) {
            $permissionExist = Permission::whereName($permission['name'])->exists();
            if (! $permissionExist) {
                Permission::updateOrCreate($permission);
            }
        }
    }
}
