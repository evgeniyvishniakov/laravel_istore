<?php

use App\Http\Controllers\admin\Category\CategoryController;
use App\Http\Controllers\admin\Home\HomeController;
use App\Http\Controllers\shop\Account\AccountController;
use App\Http\Controllers\shop\Auth\LoginController;
use App\Http\Controllers\shop\Auth\RegisterController;
use App\Http\Controllers\shop\Catalog\CatalogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('welcome');
});




Route::match(['get', 'post'], '/registrations', [RegisterController::class, 'add'])->name('register');
Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('login');
Route::get('/account', [AccountController::class, 'show'])->name('account')->middleware('auth');

Route::get('/catalog', [CatalogController::class, 'show'])->name('catalog');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');


Route::resource('admin-panel/category', CategoryController::class);
Route::get('/admin-panel', [HomeController::class, 'show'])->name('admin');
Route::get('/admin-panel/category', [CategoryController::class, 'index'])->name('category.index');
Route::delete('/admin-panel/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::get('/admin-panel/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/admin-panel/category', [CategoryController::class, 'store'])->name('category.store');
