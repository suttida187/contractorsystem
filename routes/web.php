<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\adminRegisterController;
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

Route::get('/register-admin', [adminRegisterController::class, 'create'])->name('register-admin');
Route::get('/register-contractor', [adminRegisterController::class, 'createContractor'])->name('register-contractor');
Route::post('/register-store', [adminRegisterController::class, 'store'])->name('register-store');
Route::put('/register-update/{id}', [adminRegisterController::class, 'update'])->name('register-update');
Route::get('/list-sale-pm-admin', [adminRegisterController::class, 'index'])->name('list-sale-pm-admin');
Route::get('/list-contractor', [adminRegisterController::class, 'index'])->name('list-sale-pm-admin');
Route::get('/list-edit-admin/{id}', [adminRegisterController::class, 'edit'])->name('list-edit-admin');
Route::get('/list-edit-contractor/{id}', [adminRegisterController::class, 'edit'])->name('list-edit-contractor');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');