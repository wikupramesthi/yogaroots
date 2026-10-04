<?php

namespace Database\Seeders;

use App\Models\ManagementAccess\Route;
use Illuminate\Database\Seeder;

class BannerMediaSeeder extends Seeder
{
    /**
     * Route guard for Media Library.
     * Reuses banner.* permissions so existing roles keep access.
     * Idempotent: safe to re-run.
     */
    public function run(): void
    {
        $routes = [
            'banner.loadMore' => 'banner.index',
            'banner.fotoPicker' => 'banner.index',
            'banner.albumFotos' => 'banner.index',
            'banner.modal' => 'banner.index',
            'banner.storeAlbum' => 'banner.store',
            'banner.updateAlbum' => 'banner.update',
            'banner.destroyAlbum' => 'banner.destroy',
            'articles.bulkDestroy' => 'articles.destroy',
        ];

        foreach ($routes as $route => $permission) {
            Route::firstOrCreate(
                ['route' => $route],
                ['permission_name' => $permission, 'status' => true]
            );
        }
    }
}
