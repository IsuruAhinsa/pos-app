<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DefaultRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (RoleEnum::cases() as $role) {
            Role::updateOrCreate(['name' => $role]);
        }

        $this->command->info('Default Roles added.');

        $this->assignPermissions();
    }

    protected function assignPermissions(): void
    {
        $adminRole = Role::whereName(RoleEnum::Admin->value)->first();

        $allPermissions = Permission::pluck('name', 'id');

        $adminRole->givePermissionTo($allPermissions);
    }
}
