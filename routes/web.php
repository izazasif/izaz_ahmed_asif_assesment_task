<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboarController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [HomeController::class, 'index'])->name('login');
Route::post('/login', [HomeController::class, 'login'])->name('login_2');
Route::get('/register', [HomeController::class, 'create'])->name('register');
Route::post('/register', [HomeController::class, 'register'])->name('register_save');
Route::get('/logout', [HomeController::class, 'logout']);
Route::middleware('web')->group(function () {

Route::get('/dashboard', [DashboarController::class, 'index'])->name('home');
Route::post('/deposit', [DashboarController::class, 'store_deposit'])->name('deposit_save');
Route::get('/withdraw', [DashboarController::class, 'withdraw_show'])->name('withdraw');
Route::post('/withdraw', [DashboarController::class, 'withdraw'])->name('withdraw_save');


});