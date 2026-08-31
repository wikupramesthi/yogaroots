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
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\PollController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\EventsController;
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
});

Route::post('/notifications/{id}/read', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return response()->json(['success' => true]);
})->name('notifications.read');


Route::group(['middleware' => ['web', 'auth', 'verified'], 'prefix' => 'backend'], function () {
    $superAdmin = 'role:super-admin';
    // $user = 'role:user';
    Route::resource('dashboard', DashboardController::class)->only('index');
    Route::post('/dashboard/sumber-informasi', [DashboardController::class, 'submitSumber'])->name('dashboard.submitSumber');
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
    Route::resource('banner', BannerController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('specializations', SpecializatyController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('account', AccountController::class);
    Route::get('/get-kelurahan/{kecamatan_id}', [AccountController::class, 'getKelurahan']);
    Route::resource('poll', PollController::class);
    Route::resource('pages', PagesController::class);
    Route::resource('events', EventsController::class);
    Route::resource('program', ProgramController::class);
    Route::resource('filedownload', FileDownloadController::class);
    Route::get('kontak', [FaqController::class, 'kontak'])->name('layanan.kontak');
    Route::delete(
        '/kontak/{uuid}',
        [FaqController::class, 'forceDelete']
    )->name('kontak.destroy');
    Route::resource('pegawai', PegawaiController::class);
    Route::post('pegawai/restore', [PegawaiController::class, 'restore'])->name('pegawai.restore');
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

    // Route::get('list-menu', [MenuGroupController::class, 'listMenu'])->name('list-menu');
});

require __DIR__ . '/auth.php';
