<?php

use App\Http\Controllers\admin\Attribute\AttributeController;
use App\Http\Controllers\admin\AttributeValue\AttributeValueController;
use App\Http\Controllers\admin\Category\CategoryController;
use App\Http\Controllers\admin\Product\ProductController;
use App\Http\Controllers\shop\Account\AccountController;
use App\Http\Controllers\shop\Auth\LoginController;
use App\Http\Controllers\shop\Auth\RegisterController;
use App\Http\Controllers\shop\Cart\CartController;
use App\Http\Controllers\shop\Catalog\CatalogController;
use App\Http\Controllers\shop\Checkout\CheckoutController;
use App\Http\Controllers\shop\NovaPoshta\NovaPoshtaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\Home\HomeController as ShopHomeController;
use App\Http\Controllers\Admin\Home\HomeController as AdminHomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [ShopHomeController::class, 'show'])->name('home');  // Главная страница
Route::get('/admin-panel', [AdminHomeController::class, 'show'])->name('admin');  // Админка


Route::match(['get', 'post'], '/registrations', [RegisterController::class, 'add'])->name('register');
Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('login');
Route::get('/account', [AccountController::class, 'show'])->name('account')->middleware('auth');

Route::get('/catalog', [CatalogController::class, 'show'])->name('catalog');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/admin-panel', [AdminHomeController::class, 'show'])->name('admin');
Route::resource('admin-panel/category', CategoryController::class);


Route::resource('admin-panel/attribute', AttributeController::class);
Route::resource('admin-panel/product', ProductController::class);
Route::get('admin-panel/product/{id}/duplicate', [ProductController::class, 'duplicate'])->name('product.duplicate');
Route::get('admin-panel/product/attribute-values/{attribute_id}', [ProductController::class, 'getAttributeValues']);
Route::get('/api/attribute-values/{attributeId}', [AttributeController::class, 'getValues']);

Route::post('admin-panel/attribute/{id}', [AttributeValueController::class, 'store'])->name('attribute.value.store');
Route::get('admin-panel/attribute/{attribute_slug}/value/{value_slug}/edit', [AttributeValueController::class, 'edit'])->name('attribute.value.edit');
Route::delete('/admin-panel/attribute/{attribute}/{value}', [AttributeValueController::class, 'destroy'])->name('attribute.value.destroy');
Route::put('admin-panel/attribute/{attribute_id}/value/{value_id}/', [AttributeValueController::class, 'update'])->name('attribute.value.update');

// Корзина
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Чекаут
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/nova-poshta/warehouses', [CheckoutController::class, 'getWarehouses']);
Route::get('/get-cities', [CheckoutController::class, 'getCities']);
Route::post('/warehouses', [CheckoutController::class, 'getWarehouses']);
