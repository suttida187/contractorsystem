<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\adminRegisterController;
use App\Http\Controllers\Sale\FormSaleController;
use App\Models\User;
use App\Notifications\SalesProjectUpdated;
use App\Http\Controllers\NotificationController;
use App\Events\UpdateNotification;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


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
Route::get('/home-all', [App\Http\Controllers\HomeController::class, 'indexAll'])->name('home-all');
Route::post('/search_query-project', [App\Http\Controllers\HomeController::class, 'search'])->name('search_query-project');
Route::get('/assign-work', [App\Http\Controllers\HomeController::class, 'assignWork'])->name('assign-work');
Route::get('/calendar-user/{id}', [App\Http\Controllers\HomeController::class, 'calendarUser'])->name('calendar-user');
Route::get('/create-calendar/{idUser}/{project}', [App\Http\Controllers\HomeController::class, 'createCalendar'])->name('create-calendar');
Route::get('/schedule', [App\Http\Controllers\HomeController::class, 'schedule'])->name('schedule');
Route::get('/getSchedule/{name}', [App\Http\Controllers\HomeController::class, 'getSchedule'])->name('getSchedule');
Route::get('/user-endpoint/{name}', [App\Http\Controllers\HomeController::class, 'userEndpoint'])->name('user-endpoint');
Route::get('/getProject/{id}', [App\Http\Controllers\HomeController::class, 'getProject'])->name('getProject');
Route::post('/create-calendars', [App\Http\Controllers\HomeController::class, 'createCalendars'])->name('create-calendars');
Route::post('/upload-image', [App\Http\Controllers\HomeController::class, 'uploadImage'])->name('upload-image');
Route::post('/edit-upload-image', [App\Http\Controllers\HomeController::class, 'editUploadImage'])->name('edit-upload-image');
// notifications
Route::get('/notifications-fetch', [NotificationController::class, 'fetch'])->name('notifications-fetch');
Route::get('/mark-as-read/{notificationId}/{projectId}', [NotificationController::class, 'UpdateReadAt'])->name('notifications.markAsRead');
// เทส ยิง  notifications
Route::get('test', function () {
    $notifications = "notifications success";
    event(new UpdateNotification($notifications));
    return response()->json(['success' => true, 'message' => 'Notification sent']);
}); //