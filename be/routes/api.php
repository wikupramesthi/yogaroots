<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PageController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/faqs', [FaqController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/categories', [ArticleController::class, 'category']);
Route::get('/contact/captcha', [ContactController::class, 'captcha']);
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/banners', [BannerController::class, 'index']);

// Artikel
Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('category/{slug}', [ArticleController::class, 'byCategory']);
    Route::get('{slug}', [ArticleController::class, 'show']);
});

//pegawai
Route::prefix('pegawai')->group(function () {
    Route::get('/', [PegawaiController::class, 'index']);
    Route::get('{uuid}', [PegawaiController::class, 'show']);
});

// halaman statis
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{slug}', [PageController::class, 'show']);

// halaman event
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{slug}', [EventController::class, 'show']);
