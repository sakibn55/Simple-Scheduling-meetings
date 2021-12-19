<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\MyAppointmentsController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('reminder','App\Http\Controllers\ReminderController');
Route::get('/appointments', [MyAppointmentsController::class, 'index']);

//admin
Route::get('/admin/counselors', [AdminController::class, 'getCounselors'])->name('admin.counselors');
Route::get('/admin/counselor', [AdminController::class, 'createCounselor']);
Route::post('/admin/add/counselor', [AdminController::class, 'addCounselors'])->name('admin.counselor.add');
Route::post('/admin/delete/user', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');

//admin student
Route::get('/admin/students', [AdminController::class, 'getStudents'])->name('admin.counselors');
