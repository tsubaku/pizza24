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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Админка
/*
Route::prefix('admin')->group(function () {
    Route::resources([
        'categories' => CategoryController::class,
        'products' => ProductController::class,
    ]);
});
*/



//Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
Route::group(['prefix' => 'admin'], function() {
    Route::resource('categories', CategoryController::class)
        ->names('admin.categories');
    Route::resource('products', ProductController::class)
        ->names('admin.products');
});

/*
#
Route::get('/greeting', function () {
    return 'Hello World';
})->name('greeting');
#
Route::get('/user', [\App\Http\Controllers\Admin\CategoryController::class, 'index']);
#
Route::get(
    '/admin/categories1',
    [CategoryController::class, 'index']
)->name('admin.categories1');
#
*/
