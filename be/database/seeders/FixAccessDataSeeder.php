<?php

namespace Database\Seeders;

use App\Models\ManagementAccess\MenuItem;
use App\Models\ManagementAccess\Route;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Perbaikan data akses (menu + permission) setelah modul legacy dihapus.
 *
 * Jalankan: php artisan db:seed --class=FixAccessDataSeeder
 */
class FixAccessDataSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1. Modul company (tabel `companies` tidak pernah ada) dihapus,
        //    menu "Informasi Umum" diarahkan ke Website Identity.
        MenuItem::where('route', 'company.index')->update([
            'name' => 'Website Identity',
            'route' => 'website-identity.index',
            'permission_name' => 'website-identity.index',
        ]);

        // 2. Buang route & permission sisa modul company/portofolio.
        $staleRoutes = [
            'company.index', 'company.create', 'company.store', 'company.update', 'company.destroy',
            'portofolio.index', 'portofolio.create', 'portofolio.store', 'portofolio.update', 'portofolio.destroy',
        ];
        Route::whereIn('route', $staleRoutes)->delete();
        Permission::whereIn('name', $staleRoutes)->delete();

        // 3. permission_name menu yang tidak sesuai route-nya.
        $menuPermissions = [
            'Order List' => 'orders.index',
            'My Orders' => 'orders.index',
        ];
        foreach ($menuPermissions as $menuName => $permissionName) {
            MenuItem::where('name', $menuName)->update(['permission_name' => $permissionName]);
        }

        // 4. Modul File Download hanya boleh diakses admin & super-admin
        //    (sebelumnya `filedownload.index` hanya menempel di role user & instruktur).
        $downloadPermissions = [
            'filedownload.index',
            'filedownload.store',
            'filedownload.update',
            'filedownload.destroy',
        ];
        foreach ($downloadPermissions as $name) {
            $permission = Permission::firstOrCreate(['name' => $name]);

            foreach (['super-admin', 'admin'] as $roleName) {
                $role = Role::findByName($roleName);
                if (! $role->hasPermissionTo($permission)) {
                    $role->givePermissionTo($permission);
                }
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->command?->info('Akses data diperbaiki: menu Website Identity, permission File Download, route/permission legacy dibersihkan.');
    }
}