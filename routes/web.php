<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AjaxController;

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

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

#Admin Panel
Route::group(['prefix' => 'admin'], function() {
    Route::resource('categories', CategoryController::class)
        ->names('admin.categories');

    Route::resource('products', ProductController::class)
        ->names('admin.products');

  //  $methods = ['index', 'update'];
    Route::resource('settings', SettingController::class)
      //  ->only($methods)
        ->names('admin.settings');
});

/* AJAX requests */
//Route::post('/getHash', AjaxController::class, 'getHash');

Route::post('/ajaxGetPrices', [AjaxController::class, 'ajaxGetPrices'])->name('ajaxGetPrices');
//Route::post('/ajaxGetPrices', function () {return "kkkk";})->name('ajaxGetPrices');
//Route::post('ajax/request/store', [AjaxController::class, 'ajaxRequestStore'])->name('ajax.request.store');



