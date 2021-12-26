<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvisorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyAppointmentsController;
use App\Http\Controllers\StudentController;

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

Route::get('/appointments', [MyAppointmentsController::class, 'index'])->name('admin.appointments');

//admin controller
Route::get('/admin/counselors', [AdminController::class, 'getCounselors'])->name('admin.counselors');
Route::get('/admin/counselor', [AdminController::class, 'createCounselor']);
Route::post('/admin/add/counselor', [AdminController::class, 'addCounselors'])->name('admin.counselor.add');
Route::post('/admin/delete/user', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');

//admin student
Route::get('/admin/students', [AdminController::class, 'getStudents'])->name('admin.counselors');


//advisor
Route::get('/advisor/reminder', [AdvisorController::class, 'myReminders'])->name('advisor.myReminders');
Route::get('/advisor', [AdvisorController::class, 'getAvaibility'])->name('advisor.getAvability');
Route::post('/advisor/store', [AdvisorController::class, 'store'])->name('advisor.store');
Route::post('/advisor/update', [AdvisorController::class, 'update'])->name('advisor.update');

Route::post('/advisor/delete', [AdvisorController::class, 'destroy'])->name('advisor.destroy');

Route::post('/advisor/confirmation', [AdvisorController::class, 'confirmation'])->name('advisor.confirmation');


//student controller
Route::get('/student', [StudentController::class, 'index'])->name('student.index');
Route::get('/student/reminders', [StudentController::class, 'myReminders'])->name('student.myReminders');

//get advisor avaibilities

Route::get('/advisor/avaibility/{advisor_email}', [StudentController::class, 'advisorAvaibility'])->name('student.advisorAvaibility');
