<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    const PERMISSIONS = [
        'bookings.list',
        'bookings.create',
        'bookings.update',
        'bookings.delete',
        'logout',
    ];

    const ROLES = [
        'admin' => [
            'bookings.list',
            'bookings.create',
            'bookings.update',
            'bookings.delete',
            'logout',
        ],
        'guest' => [
            'bookings.list',
            'logout',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = self::PERMISSIONS;
        $roles = self::ROLES;

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach ($roles as $roleKey => $rolePermission) {
            $roleData = Role::where('name', $roleKey)->get()->isEmpty();
            if ($roleData) {
                $userRole = Role::create(['name' => $roleKey]);

                if (!empty($rolePermission)) {
                    $userRole->givePermissionTo($rolePermission);
                }
            }
        }
    }
}
