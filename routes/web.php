<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvisorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Mail\AdvisorCreated;
use Illuminate\Support\Facades\Mail;

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
    return redirect()->route('login');
});

Route::get('/profile', [UserController::class, 'index'])->name('profile');
Route::get('/profile/{email}', [UserController::class, 'view']);
Route::post('/profile', [UserController::class, 'update'])->name('user.profile.save');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.change');
Route::get('/change-password', [UserController::class, 'password']);
Route::get('/dashboard', function () {
    $role = auth()->user()->role->title;
    switch ($role) {
        case 'student':
            return redirect()->route('student.index');
            break;
        case 'advisor':
            return redirect()->route('advisor.getAvability');
            break;
        case 'admin':
            return redirect()->route('admin.appointments');
            break;
    }
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::resource('reminder', 'App\Http\Controllers\ReminderController');

Route::get('/admin/appointments', [AdminController::class, 'index'])->name('admin.appointments');

//admin controller
Route::get('/admin/advisors', [AdminController::class, 'getAdvisor'])->name('admin.advisors');
Route::get('/admin/appointment/{slug}', [AdminController::class, 'viewAppointment']);
Route::get('/admin/advisor', [AdminController::class, 'createAdvisor']);
Route::post('/admin/add/advisor', [AdminController::class, 'addAdvisor'])->name('admin.advisor.add');
Route::post('/admin/delete/user', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');

//admin student
Route::get('/admin/students', [AdminController::class, 'getStudents']);


//advisor
Route::get('/advisor/reminder', [AdvisorController::class, 'myReminders'])->name('advisor.myReminders');
Route::get('/advisor', [AdvisorController::class, 'getAvaibility'])->name('advisor.getAvability');
Route::post('/advisor/store', [AdvisorController::class, 'store'])->name('advisor.store');
Route::post('/advisor/update', [AdvisorController::class, 'update'])->name('advisor.update');

Route::post('/advisor/delete', [AdvisorController::class, 'destroy'])->name('advisor.destroy');

Route::post('/advisor/confirmation', [AdvisorController::class, 'confirmation'])->name('advisor.confirmation');
Route::get('/advisor/appointment/{slug}', [AdvisorController::class, 'viewAppointment']);


//student controller
Route::get('/student', [StudentController::class, 'index'])->name('student.index');
Route::get('/appointment/{slug}', [StudentController::class, 'viewAppointment']);
Route::get('/student/reminders', [StudentController::class, 'myReminders'])->name('student.myReminders');

//get advisor avaibilities

Route::get('/advisor/avaibility/{advisor_email}', [StudentController::class, 'advisorAvaibility'])->name('student.advisorAvaibility');


//notification read
Route::post('/notification/read', [UserController::class, 'notification_read']);
Route::get('/notifications', [UserController::class, 'notification_count']);

Route::post('account/delete', [UserController::class, 'destroy'])->name('account.destroy');
