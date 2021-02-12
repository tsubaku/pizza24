<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

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
});


