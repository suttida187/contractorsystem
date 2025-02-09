<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\adminRegisterController;
use App\Http\Controllers\Sale\FormSaleController;


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

// Auth
Auth::routes();
Route::get('register', function () {
    abort(403, 'การลงทะเบียนถูกปิดใช้งาน');
}); //

//Sale
Route::get('/create-form', [FormSaleController::class, 'create'])->name('create-form');
Route::post('/create-project-store', [FormSaleController::class, 'store'])->name('create-project-store');



// Admin
Route::get('/register-admin', [adminRegisterController::class, 'create'])->name('register-admin');
Route::get('/register-contractor', [adminRegisterController::class, 'createContractor'])->name('register-contractor');
Route::post('/register-store', [adminRegisterController::class, 'store'])->name('register-store');
Route::put('/register-update/{id}', [adminRegisterController::class, 'update'])->name('register-update');
Route::get('/list-sale-pm-admin', [adminRegisterController::class, 'index'])->name('list-sale-pm-admin');
Route::get('/list-contractor', [adminRegisterController::class, 'index'])->name('list-sale-pm-admin');
Route::get('/list-edit-admin/{id}', [adminRegisterController::class, 'edit'])->name('list-edit-admin');
Route::get('/list-edit-contractor/{id}', [adminRegisterController::class, 'edit'])->name('list-edit-contractor');
Route::get('/delete-user/{id}', [adminRegisterController::class, 'destroy'])->name('delete-user');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');