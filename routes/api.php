<?php

use App\Http\Controllers\AlamatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\GambarProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\WishlistController;
use App\Models\Promo;
use Illuminate\Support\Facades\Route;

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

Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);

Route::group([
    "middleware" => ["auth:api"]
], function () {
    Route::post("logout", [AuthController::class, "logout"]);
    Route::put("change-password", [AuthController::class, "changePassword"]);
    Route::put("update-profile", [AuthController::class, "updateProfile"]);
    Route::post("refresh", [AuthController::class, "refresh"]);
    Route::get("me", [AuthController::class, "me"]);
    Route::apiResource('review', ReviewController::class)->except(['index', 'show']);
    Route::apiResource('barang-keluar', BarangKeluarController::class);
    Route::apiResource('alamat', AlamatController::class)->only(['index']);
    Route::apiResource('transaksi', TransaksiController::class)->except(['index']);
    Route::get('transaksi/{id}/barang-keluar', [TransaksiController::class, 'getBarang']);
    Route::apiResource('alamat', AlamatController::class)->except(['index']);
    Route::get('alamat/{id}/user', [AlamatController::class, 'getByUser']);
    Route::get('alamat/user/personal', [AlamatController::class, 'getPersonal']);
    Route::get('transaksi/user/personal', [TransaksiController::class, 'getByUser']);
    Route::post('checkout', [TransaksiController::class, 'checkout']);
    Route::get('check-promo', [PromoController::class, 'checkPromo']);
    Route::get('review/user', [ReviewController::class, 'getReviewByUserId']);
});

Route::group([
    "middleware" => ["auth:api", "isAdmin"]
], function () {
    route::get('users', [AuthController::class, 'getAllUsers']);
    route::delete('users/{id}', [AuthController::class, 'deleteUser']);
    route::put('users/{id}/change-role', [AuthController::class, 'changeUserRole']);
    route::post('produk', [ProdukController::class, 'store']);
    route::put('produk/{id}', [ProdukController::class, 'update']);
    route::delete('produk/{id}', [ProdukController::class, 'destroy']);
    Route::apiResource("promo", PromoController::class)->except(["index", "show"]);
    route::post('variant', [VariantController::class, 'store']);
    route::put('variant/{id}', [VariantController::class, 'update']);
    route::delete('variant/{id}', [VariantController::class, 'destroy']);
    Route::post('gambar', [GambarProdukController::class, 'store']);
    Route::put('gambar/{id}', [GambarProdukController::class, 'update']);
    Route::delete('gambar/{id}', [GambarProdukController::class, 'destroy']);
    Route::prefix('kategori')->group(function () {
        Route::post('/', [KategoriController::class, 'store']);
        Route::put('/{id}', [KategoriController::class, 'update']);
        Route::delete('/{id}', [KategoriController::class, 'destroy']);
    });
    Route::apiResource('transaksi', TransaksiController::class)->only(['index']);
    Route::apiResource('alamat', AlamatController::class)->only(['index']);
    Route::apiResource('barang-keluar', BarangKeluarController::class)->only(['index']);
});



Route::apiResource("promo", PromoController::class)->except(["store", "update", "destroy"]);
Route::apiResource('review', ReviewController::class)->except(['store', 'update', 'destroy']);
Route::get('review/produk/{id}', [ReviewController::class, 'getbyProduct']);


route::get('produk', [ProdukController::class, 'index']);
route::get('produk/{slug}', [ProdukController::class, 'show']);

route::get('produk/{id}/variant', [ProdukController::class, 'variant']);
route::get('produk/{id}/gambar', [ProdukController::class, 'gambar']);

route::get('variant', [VariantController::class, 'index']);
route::get('variant/{id}', [VariantController::class, 'show']);


Route::get('gambar', [GambarProdukController::class, 'index']);
Route::get('gambar/{id}', [GambarProdukController::class, 'show']);



Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/produk', [KategoriController::class, 'showByProduk']);
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index']);
        Route::get('/{id}', [WishlistController::class, 'show']);
        Route::post('/', [WishlistController::class, 'store']);
        Route::put('/{id}', [WishlistController::class, 'update']);
        Route::delete('/{id}', [WishlistController::class, 'destroy']);
    });

    Route::prefix('keranjang')->group(function () {
        Route::get('/', [KeranjangController::class, 'index']);
        Route::post('/', [KeranjangController::class, 'store']);
        Route::get('/{id}', [KeranjangController::class, 'show']);
        Route::get('/{id}/produk', [KeranjangController::class, 'showByProduk']);
        Route::put('/{id}', [KeranjangController::class, 'update']);
        Route::delete('/{id}', [KeranjangController::class, 'destroy']);
    });
});
