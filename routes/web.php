<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\adminRegisterController;
use App\Http\Controllers\Sale\FormSaleController;
use App\Models\User;
use App\Notifications\SalesProjectUpdated;
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

use App\Models\SalesProjects;

Route::get('/test-update-admin/{project_id}/{admin_id}', function ($project_id, $admin_id) {
    $project = SalesProjects::find($project_id);
    if ($project) {
        $project->responsible_admin = $admin_id;
        $project->save();

        // ✅ ตรวจสอบว่า User มีอยู่จริงก่อนส่ง Notification
        $admin = User::find($admin_id);
        if ($admin) {
            $admin->notify(new SalesProjectUpdated($project)); // 🎯 ส่งการแจ้งเตือน
        }

        return 'Updated successfully and notification sent!';
    }
    return 'Project not found!';
});


Route::get('/mark-as-read/{id}', function ($id) {
    $notification = auth()->user()->notifications()->where('id', $id)->first();
    if ($notification) {
        $notification->markAsRead();
    }
    return redirect()->back();
})->name('notifications.markAsRead');
