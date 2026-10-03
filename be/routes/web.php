<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ManagementAccess\RoleController;
use App\Http\Controllers\ManagementAccess\UserController;
use App\Http\Controllers\ManagementAccess\RouteController;
use App\Http\Controllers\ManagementAccess\MenuItemController;
use App\Http\Controllers\ManagementAccess\MenuGroupController;
use App\Http\Controllers\ManagementAccess\PermissionController;

use App\Http\Controllers\Admin\PortofolioController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\TentangPerusahaanController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SpecializatyController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\FileDownloadController;
use App\Http\Controllers\Admin\InstrukturController;
use App\Http\Controllers\Admin\StudioController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\PollController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\Security\AuditLogController;
use App\Http\Controllers\Admin\Security\FailedLoginController;
use App\Http\Controllers\Admin\Security\LoginActivityController;
use App\Http\Controllers\Admin\Security\LoginLockoutController;

// payment
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\ClassScheduleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ClassBookingController;
use App\Http\Controllers\Admin\CheckoutController;
use App\Http\Controllers\Admin\GlobalSearchController;
use App\Http\Controllers\Admin\WebsiteIdentityController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\MinifyHtml;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Socialite Routes GOOGLE
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('googleAuth');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Keep-alive to reset the idle timer (called via JS when the user clicks "Stay signed in")
    Route::post('/keep-alive', function (\Illuminate\Http\Request $request) {
        $request->session()->put('last_activity', time());
        return response()->json(['ok' => true]);
    })->name('keep-alive');
});

Route::post('/notifications/{id}/read', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return response()->json(['success' => true]);
})->name('notifications.read');


Route::group(['middleware' => ['web', 'auth', 'verified'], 'prefix' => 'backend'], function () {
    $superAdmin = 'role:super-admin';
    // $user = 'role:user';
    Route::post('/dashboard/sumber-informasi', [DashboardController::class, 'submitSumber'])->name('dashboard.submitSumber');
    // Cross-module global search for the command palette (Ctrl+K)
    Route::get('/search', [GlobalSearchController::class, 'index'])->name('search');
    Route::resource('dashboard', DashboardController::class)->only('index');
    Route::resource('user', UserController::class)->middleware($superAdmin)->only('index', 'store', 'update', 'destroy');
    Route::resource('route', RouteController::class)->middleware($superAdmin)->only('index', 'store', 'update', 'destroy');
    Route::resource('permission', PermissionController::class)->middleware($superAdmin)->only('index', 'store', 'update', 'destroy');
    Route::resource('role', RoleController::class)->middleware([$superAdmin])->only('index', 'store', 'update', 'destroy');
    Route::resource('menu', MenuGroupController::class)->middleware($superAdmin)->only('index', 'store', 'update', 'destroy');
    Route::resource('menu.item', MenuItemController::class)->middleware($superAdmin)->only('index', 'store', 'update', 'destroy');
    Route::resource('portofolio', PortofolioController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('company', TentangPerusahaanController::class);
    Route::get('banner/media', [BannerController::class, 'loadMore'])->name('banner.loadMore');
    Route::get('banner/foto-picker', [BannerController::class, 'fotoPicker'])->name('banner.fotoPicker');
    Route::get('banner/album-fotos/{album}', [BannerController::class, 'albumFotos'])->name('banner.albumFotos');
    Route::get('banner/modal/{tipe}/{uuid}', [BannerController::class, 'modal'])->whereIn('tipe', ['foto', 'video', 'album', 'view-album'])->name('banner.modal');
    Route::resource('banner', BannerController::class);
    Route::post('banner/album', [BannerController::class, 'storeAlbum'])->name('banner.storeAlbum');
    Route::put('banner/album/{album}', [BannerController::class, 'updateAlbum'])->name('banner.updateAlbum');
    Route::delete('banner/album/{album}', [BannerController::class, 'destroyAlbum'])->name('banner.destroyAlbum');
    Route::resource('categories', CategoryController::class);
    Route::resource('specializations', SpecializatyController::class);
    Route::delete('articles/bulk', [ArticleController::class, 'bulkDestroy'])->name('articles.bulkDestroy');
    Route::resource('articles', ArticleController::class);
    Route::resource('account', AccountController::class);
    Route::get('/get-kelurahan/{kecamatan_id}', [AccountController::class, 'getKelurahan']);
    Route::resource('poll', PollController::class);
    Route::resource('pages', PagesController::class);
    Route::resource('events', EventsController::class);
    Route::resource('program', ProgramController::class);
    Route::resource('filedownload', FileDownloadController::class);
    // Website Identitas ala DBMSDA (singleton: satu form, tanpa CRUD tabel)
    Route::get('website-identity', [WebsiteIdentityController::class, 'index'])->name('website-identity.index');
    Route::put('website-identity', [WebsiteIdentityController::class, 'update'])->name('website-identity.update');
    Route::get('pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/export', [PenggunaController::class, 'export'])->name('pengguna.export');

    //payment
    Route::get(
        '/packages/members',
        [PackageController::class, 'members']
    )->name('packages.member');
    Route::resource('packages', PackageController::class);
    Route::resource('studios', StudioController::class);
    Route::resource('classes', ClassController::class);
    Route::patch(
        '/classes/{uuid}/level',
        [ClassController::class, 'changeLevel']
    )->name('classes.change-level');
    Route::get(
        '/class-schedules/print',
        [ClassScheduleController::class, 'print']
    )->name('class-schedules.print');
    Route::get('/checkout/package/{packageUuid}', [
        CheckoutController::class,
        'package'
    ])->name('checkout.package');

    Route::resource('class-schedules', ClassScheduleController::class);
    Route::resource('orders', OrderController::class);


    Route::resource('payments', PaymentController::class)
        ->only(['index', 'show']);
    Route::resource('class-bookings', ClassBookingController::class)
        ->only(['index', 'show', 'update']);
    // end payment

    Route::get('kontak', [FaqController::class, 'kontak'])->name('layanan.kontak');
    Route::delete(
        '/kontak/{uuid}',
        [FaqController::class, 'forceDelete']
    )->name('kontak.destroy');
    Route::resource('instruktur', InstrukturController::class);
    Route::post('instruktur/restore', [InstrukturController::class, 'restore'])->name('instruktur.restore');
    Route::get('/mobile/instruktur', [InstrukturController::class, 'mobile'])
        ->name('instruktur.mobile');
    Route::post('program/upload', [ProgramController::class, 'upload'])->name('program.upload');
    Route::get('/program/{id}/edit/{uuid}', [ProgramController::class, 'edit'])->name('program.edit');
    Route::patch('/program/update/{id}/{uuid}', [ProgramController::class, 'update'])->name('program.update');
    Route::get('/program/cetak/{id}/{uuid}', [ProgramController::class, 'cetakPdf'])->name('program.cetak');
    Route::post('/upload/foto-kegiatan', [ProgramController::class, 'uploadFoto'])->name('upload.foto.kegiatan');
    Route::post('/program/modal-store', [ProgramController::class, 'modalStore'])->name('program.modalStore');
    Route::put('/program/update/{id}', [ProgramController::class, 'modalUpdate'])->name('program.modalUpdate');
    Route::put('/program/{id}/update-status', [ProgramController::class, 'updateStatus'])->name('program.updateStatus');
    Route::patch('/program/{id}/verifikasi', [ProgramController::class, 'verifikasi'])->name('program.verifikasi');
    Route::post('/program/video', [ProgramController::class, 'videoStore'])->name('program.videoStore');
    Route::post('/program/presentasi', [ProgramController::class, 'presentasiStore'])->name('program.presentasiStore');

    Route::patch('/pages/{uuid}/sidebar', [PagesController::class, 'updateSidebar'])->name('pages.updateSidebar');

    // Security (audit log, login activity, lockout) — DBMSDA-style
    Route::prefix('security')->name('security.')->group(function () {
        Route::get('login-activity', [LoginActivityController::class, 'index'])->name('login-activity.index');
        Route::delete('login-activity/bulk', [LoginActivityController::class, 'bulkDestroy'])->name('login-activity.bulkDestroy');
        Route::delete('login-activity/clear', [LoginActivityController::class, 'clear'])->name('login-activity.clear');
        Route::delete('login-activity/{loginActivity}', [LoginActivityController::class, 'destroy'])->name('login-activity.destroy');

        Route::get('login-lockout', [LoginLockoutController::class, 'index'])->name('login-lockout.index');
        Route::delete('login-lockout/bulk', [LoginLockoutController::class, 'bulkDestroy'])->name('login-lockout.bulkDestroy');
        Route::delete('login-lockout/{loginLockout}', [LoginLockoutController::class, 'destroy'])->name('login-lockout.destroy');

        Route::get('audit-log', [AuditLogController::class, 'index'])->name('audit-log.index');
        Route::get('audit-log/export-pdf', [AuditLogController::class, 'exportPdf'])->name('audit-log.exportPdf');
        Route::delete('audit-log/bulk', [AuditLogController::class, 'bulkDestroy'])->name('audit-log.bulkDestroy');
        Route::delete('audit-log/clear', [AuditLogController::class, 'clear'])->name('audit-log.clear');
        Route::delete('audit-log/{auditLog}', [AuditLogController::class, 'destroy'])->name('audit-log.destroy');

        Route::get('failed-login', [FailedLoginController::class, 'index'])->name('failed-login.index');
        Route::delete('failed-login/bulk', [FailedLoginController::class, 'bulkDestroy'])->name('failed-login.bulkDestroy');
        Route::delete('failed-login/clear', [FailedLoginController::class, 'clear'])->name('failed-login.clear');
        Route::delete('failed-login/{failedLogin}', [FailedLoginController::class, 'destroy'])->name('failed-login.destroy');
    });

    // Route::get('list-menu', [MenuGroupController::class, 'listMenu'])->name('list-menu');
});

require __DIR__ . '/auth.php';
