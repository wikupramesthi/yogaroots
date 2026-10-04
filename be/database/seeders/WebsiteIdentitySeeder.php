<?php

namespace Database\Seeders;

use App\Models\ManagementAccess\MenuGroup;
use App\Models\ManagementAccess\MenuItem;
use App\Models\ManagementAccess\Route;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WebsiteIdentitySeeder extends Seeder
{
    /**
     * Seed permissions, menu, and route guard for the
     * Website Identity module. Idempotent: safe to re-run.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'website-identity.index',
            'website-identity.update',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Attach to "Settings" group if it exists, otherwise create it.
        $menuGroup = MenuGroup::where('name', 'Settings')->first()
            ?? MenuGroup::firstOrCreate(
                ['permission_name' => 'menu.pengaturan'],
                [
                    'name' => 'Settings',
                    'icon' => 'bx-cog',
                    'status' => true,
                    'position' => 90,
                ]
            );

        MenuItem::updateOrCreate(
            [
                'route' => 'website-identity.index',
                'menu_group_id' => $menuGroup->id,
            ],
            [
                'name' => 'Website Identity',
                'status' => true,
                'permission_name' => 'website-identity.index',
                'position' => 99,
            ]
        );

        $routes = [
            'website-identity.index' => 'website-identity.index',
            'website-identity.update' => 'website-identity.update',
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
