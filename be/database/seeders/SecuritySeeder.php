<?php

namespace Database\Seeders;

use App\Models\ManagementAccess\MenuGroup;
use App\Models\ManagementAccess\MenuItem;
use App\Models\ManagementAccess\Route;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SecuritySeeder extends Seeder
{
    /**
     * Seed permissions, menu, and route guard for the Security (Keamanan) module.
     * Idempotent: aman dijalankan ulang.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'menu.keamanan',
            'login-activity.index',
            'login-activity.destroy',
            'login-lockout.index',
            'login-lockout.destroy',
            'audit-log.index',
            'audit-log.destroy',
            'failed-login.index',
            'failed-login.destroy',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $menuGroup = MenuGroup::firstOrCreate(
            ['permission_name' => 'menu.keamanan'],
            [
                'name' => 'Keamanan',
                'icon' => 'bx-shield-alt-2',
                'status' => true,
                'position' => 99,
            ]
        );

        $items = [
            ['name' => 'Login Activity', 'route' => 'security.login-activity.index', 'permission_name' => 'login-activity.index', 'position' => 1],
            ['name' => 'Audit Log', 'route' => 'security.audit-log.index', 'permission_name' => 'audit-log.index', 'position' => 2],
            ['name' => 'Failed Login', 'route' => 'security.failed-login.index', 'permission_name' => 'failed-login.index', 'position' => 3],
            ['name' => 'Blokir Login', 'route' => 'security.login-lockout.index', 'permission_name' => 'login-lockout.index', 'position' => 4],
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
            'security.login-activity.index' => 'login-activity.index',
            'security.login-activity.bulkDestroy' => 'login-activity.destroy',
            'security.login-activity.clear' => 'login-activity.destroy',
            'security.login-activity.destroy' => 'login-activity.destroy',
            'security.login-lockout.index' => 'login-lockout.index',
            'security.login-lockout.bulkDestroy' => 'login-lockout.destroy',
            'security.login-lockout.destroy' => 'login-lockout.destroy',
            'security.audit-log.index' => 'audit-log.index',
            'security.audit-log.exportPdf' => 'audit-log.index',
            'security.audit-log.bulkDestroy' => 'audit-log.destroy',
            'security.audit-log.clear' => 'audit-log.destroy',
            'security.audit-log.destroy' => 'audit-log.destroy',
            'security.failed-login.index' => 'failed-login.index',
            'security.failed-login.bulkDestroy' => 'failed-login.destroy',
            'security.failed-login.clear' => 'failed-login.destroy',
            'security.failed-login.destroy' => 'failed-login.destroy',
        ];

        foreach ($routes as $route => $permission) {
            Route::firstOrCreate(
                ['route' => $route],
                ['permission_name' => $permission, 'status' => true]
            );
        }

        $roles = Role::whereIn('name', ['super-admin', 'admin'])->get();
        foreach ($roles as $role) {
            $role->givePermissionTo($permissions);
        }
    }
}
