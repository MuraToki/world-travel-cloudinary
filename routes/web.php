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

Route::get('guest', [App\Http\Controllers\Auth\LoginController::class,'guestLogin'])->name('login.guest');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//体験記の作成
Route::get('/create', [App\Http\Controllers\HomeController::class, 'create'])->name('create');

//体験記の登録
Route::post('/store', [App\Http\Controllers\HomeController::class, 'store'])->name('store');
//体験記の削除
Route::post('/delete/{id}', [App\Http\Controllers\HomeController::class, 'postdelete'])->name('post.delete');
//それぞれの投稿一覧
Route::get('/user/{user_id}', [App\Http\Controllers\HomeController::class, 'show'])->name('show');
});