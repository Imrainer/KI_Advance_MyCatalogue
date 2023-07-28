<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthControllers;
use App\Http\Controllers\API\UserControllers;
use App\Http\Controllers\API\CatalogueControllers;
use App\Http\Controllers\API\CategoryControllers;
use App\Http\Controllers\API\CarouselControllers;
use App\Http\Controllers\API\CityControllers;
use App\Http\Controllers\API\ProvinceControllers;
use App\Http\Controllers\API\ReviewControllers;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// <!--AUTH--!>

Route::prefix('auth')->group(function () {
    Route::post('/login',[AuthControllers::class, 'login']);
    Route::post('/logout', [AuthControllers::class, 'logout']);
    Route::get('/me', [AuthControllers::class, 'getUserByToken']);
    Route::post('/register', [AuthControllers::class, 'register']);
});

// <!--USER--!>

Route::prefix('user')->group(function () {
    Route::post('/edit-profile',[UserControllers::class, 'edit']);
    Route::post('/edit-password',[UserControllers::class, 'editPassword']);
    Route::post('/edit-password/{token}',[UserControllers::class, 'editPasswordToken']);
    Route::post('/forgot-password',[UserControllers::class, 'forgotPassword']);
});

// <!--CATALOGUE---!>

Route::prefix('catalogue')->group(function () {
    Route::post('/create',[CatalogueControllers::class, 'create']);
    Route::get('/index',[CatalogueControllers::class, 'index']);
    Route::get('/filterProvince/{provinceId}', [CatalogueControllers::class, 'filterByProvince']);
    Route::get('/filterCity/{cityId}', [CatalogueControllers::class, 'filterByCity']);
    Route::get('/{uuid}',[CatalogueControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[CatalogueControllers::class, 'edit']);
    Route::post('/favorite/{uuid}',[CatalogueControllers::class, 'favorite']);
    Route::post('/unfavorite/{uuid}',[CatalogueControllers::class, 'unfavorite']);
    Route::delete('/delete/{uuid}',[CatalogueControllers::class,'delete']);
});

// <!--CAROUSEL---!>

Route::prefix('carousel')->group(function () {
    Route::post('/create', [CarouselControllers::class, 'create']);
    Route::get('/index', [CarouselControllers::class, 'index']);
    Route::get('/{uuid}',[CarouselControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[CarouselControllers::class, 'edit'])->name('edit_carousel');
    Route::delete('/delete/{uuid}', [CarouselControllers::class, 'delete'])->name('delete_carousel');
});

// <!--CATEGORY---!>

Route::prefix('category')->group(function () {
    Route::post('/create', [CategoryControllers::class, 'create']);
    Route::get('/index', [CategoryControllers::class, 'read']);
    Route::get('/{uuid}',[CategoryControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[CategoryControllers::class, 'edit'])->name('edit_category');
    Route::delete('/delete/{uuid}', [CategoryControllers::class, 'delete'])->name('delete_category');
});

// <!--PROVINCE---!>

Route::prefix('province')->group(function () {
    Route::post('/create', [ProvinceControllers::class, 'create']);
    Route::get('/index', [ProvinceControllers::class, 'read']);
    Route::get('/{uuid}',[ProvinceControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[ProvinceControllers::class, 'edit'])->name('edit_province');
    Route::delete('/delete/{uuid}', [ProvinceControllers::class, 'delete'])->name('delete_province');
});

// <!--CITY---!>

Route::prefix('city')->group(function () {
    Route::post('/create', [CityControllers::class, 'create']);
    Route::get('/index', [CityControllers::class, 'read']);
    Route::get('/{uuid}',[CityControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[CityControllers::class, 'edit'])->name('edit_city');
    Route::delete('/delete/{uuid}', [CityControllers::class, 'delete'])->name('delete_city');
});

// <!--REVIEW---!>
Route::prefix('review')->group(function () {
    Route::post('/create', [ReviewControllers::class, 'create']);
    Route::get('/index', [ReviewControllers::class, 'index']);
    Route::get('/{uuid}',[ReviewControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[ReviewControllers::class, 'edit'])->name('edit_review');
    Route::delete('/delete/{uuid}', [ReviewControllers::class, 'delete'])->name('delete_review');
});