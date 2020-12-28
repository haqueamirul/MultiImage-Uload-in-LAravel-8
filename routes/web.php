<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');

Route::get('/image', [App\Http\Controllers\FileController::class, 'create']);
Route::post('/image', [App\Http\Controllers\FileController::class, 'store']);
// Route::get('image', [FileController::class, 'create']); 
// Route::post('image', [FileController::class, 'store']);
