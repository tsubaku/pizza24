<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\Cart_ItemController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\SiteCartController;

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

#Index page
Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('index');

#Cart page
Route::resource('cart', SiteCartController::class)->names('cart');

Auth::routes();

#Admin Panel
Route::group(['prefix' => 'admin'], function () {
    Route::resource('categories', CategoryController::class)
        ->names('admin.categories');

    Route::resource('products', ProductController::class)
        ->names('admin.products');

    Route::resource('carts', CartController::class)
        ->names('admin.carts');

    Route::resource('cart_items', Cart_ItemController::class)
        ->names('admin.cart_items');

    $methods = ['index', 'update'];
    Route::resource('settings', SettingController::class)
        ->only($methods)
        ->names('admin.settings');
});

/* AJAX requests */
Route::post('/ajaxGetPrices', [AjaxController::class, 'ajaxGetPrices'])->name('ajaxGetPrices');
Route::post('/changeProductQuantity', [AjaxController::class, 'changeProductQuantity'])->name('changeProductQuantity');



//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/welcome', function () {
//    return view('welcome');
//});


