<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BrandStoryController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Middleware\CheckUserHasAddress;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/brand-story', [BrandStoryController::class, 'index'])->name('brand_story');
Route::get('/party', [PartyController::class, 'index'])->name('party');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/address', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/address', [AddressController::class, 'update'])->name('address.update');

    Route::get('/order/transaction', [OrderController::class, 'transaction'])->name('order.transaction');

    Route::middleware(CheckUserHasAddress::class)->group(function () {
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/order/{order}/cart', [OrderController::class, 'cart'])->name('order.show.cart');
        Route::post('/order/{order}/cart', [OrderController::class, 'docart'])->name('order.show.docart');
        Route::get('/order/{order}/add/{product}', [OrderController::class, 'add'])->name('order.show.add');
        Route::post('/order/{order}/add/{product}', [OrderController::class, 'doadd'])->name('order.show.doadd');
    });
});

require __DIR__ . '/auth.php';
