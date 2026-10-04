<?php

namespace Database\Seeders;

use App\Models\ManagementAccess\MenuGroup;
use App\Models\ManagementAccess\MenuItem;
use App\Models\ManagementAccess\Route;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MembershipSeeder extends Seeder
{
    /**
     * Seed permissions, menu, and route guard for the
     * Memberships (members + class bookings) module.
     * Also registers manual order verification routes.
     * Idempotent: safe to re-run.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminPermissions = [
            'memberships.index',
            'memberships.show',
            'class-bookings.index',
            'class-bookings.store',
            'class-bookings.checkin',
            'class-bookings.cancel',
            'orders.approve',
            'orders.reject',
            'orders.proof',
        ];

        $memberPermissions = [
            'memberships.index',
            'memberships.show',
            'class-bookings.index',
            'class-bookings.store',
            'class-bookings.checkin',
            'class-bookings.cancel',
            'orders.proof',
        ];

        foreach (array_unique(array_merge($adminPermissions, $memberPermissions)) as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $menuGroup = MenuGroup::firstOrCreate(
            ['permission_name' => 'menu.memberships'],
            [
                'name' => 'Memberships',
                'icon' => 'bx-id-card',
                'status' => true,
                'position' => 55,
            ]
        );

        $items = [
            ['name' => 'All Members', 'route' => 'memberships.index', 'permission_name' => 'memberships.index', 'position' => 1],
            ['name' => 'Bookings', 'route' => 'class-bookings.index', 'permission_name' => 'class-bookings.index', 'position' => 2],
        ];

        foreach ($items as $item) {
            MenuItem::firstOrCreate(
                [
                    'route' => $item['route'],
                    'menu_group_id' => $menuGroup->id,
                ],
                [
                    'name' => $item['name'],
                    'status' => true,
                    'permission_name' => $item['permission_name'],
                    'position' => $item['position'],
                ]
            );
        }

        $routes = [
            'memberships.index' => 'memberships.index',
            'memberships.show' => 'memberships.show',
            'class-bookings.index' => 'class-bookings.index',
            'class-bookings.store' => 'class-bookings.store',
            'class-bookings.checkin' => 'class-bookings.checkin',
            'class-bookings.cancel' => 'class-bookings.cancel',
            'class-bookings.directCheckin' => 'class-bookings.checkin',
            'orders.approve' => 'orders.approve',
            'orders.reject' => 'orders.reject',
            'orders.proof' => 'orders.proof',
            'orders.proof.show' => 'orders.proof',
        ];

        foreach ($routes as $route => $permission) {
            Route::firstOrCreate(
                ['route' => $route],
                ['permission_name' => $permission, 'status' => true]
            );
        }

        $adminRoles = Role::whereIn('name', ['super-admin', 'admin'])->get();
        foreach ($adminRoles as $role) {
            $role->givePermissionTo($adminPermissions);
        }

        $memberRoles = Role::whereIn('name', ['user'])->get();
        foreach ($memberRoles as $role) {
            $role->givePermissionTo($memberPermissions);
        }
    }
}
