<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

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
Route::get('/',function(){
    return view('welcome');
});

Route::prefix('user')->name('user.')->group(function(){
    Route::middleware(['guest'])->group(function(){
        Route::get('register',[UserController::class,'register'])->name('register');
        Route::get('login',[UserController::class,'login'])->name('login');
        Route::post('store',[UserController::class,'store'])->name('store');
        Route::post('login',[UserController::class,'dologin'])->name('doLogin');
    });
    Route::middleware(['auth'])->group(function(){
        Route::post('logout',[UserController::class,'logout'])->name('logout');
        Route::get('/',[UserController::class,'index'])->name('home');
    });
});

Route::prefix('message')->name('message.')->middleware(['auth'])->group(function(){
    Route::post('ajax/store',[MessageController::class,'store'])->name('store');
    Route::get('ajax/index',[MessageController::class,'index'])->name('index');
    Route::get('ajax/users',[MessageController::class,'users'])->name('users');
    Route::get('ajax/authUser',[MessageController::class,'authUser'])->name('authUser');
});
