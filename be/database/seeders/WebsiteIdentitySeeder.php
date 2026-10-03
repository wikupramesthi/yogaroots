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
     * Seed permissions, menu, dan route guard untuk modul
     * Website Identitas (ala DBMSDA). Idempotent: aman dijalankan ulang.
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

        // Tempel ke grup "Settings" bila ada, kalau tidak buat grup "Pengaturan".
        $menuGroup = MenuGroup::where('name', 'Settings')->first()
            ?? MenuGroup::firstOrCreate(
                ['permission_name' => 'menu.pengaturan'],
                [
                    'name' => 'Pengaturan',
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
