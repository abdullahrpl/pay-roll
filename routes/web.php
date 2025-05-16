<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;

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

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    // Employee Management
    Route::resource('employees', EmployeeController::class);

    // Attendance Management
    Route::resource('attendances', AttendanceController::class);

    // Salary Management
    Route::resource('salaries', SalaryController::class);
    Route::get('/salaries/{salary}/payslip', [SalaryController::class, 'generatePayslip'])->name('salaries.payslip');
    Route::post('/salaries/{salary}/send-notification', [SalaryController::class, 'sendNotification'])->name('salaries.sendNotification');
    Route::post('/salaries/{salary}/mark-pending', [SalaryController::class, 'markPending'])->name('salaries.markPending');
    Route::post('/salaries/{salary}/mark-paid', [SalaryController::class, 'markPaid'])->name('salaries.markPaid');
});

// Employee Routes
Route::middleware(['auth'])->prefix('employee')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'employeeDashboard'])->name('employee.dashboard');

    // Attendance
    Route::post('/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockIn');
    Route::post('/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockOut');
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('employee.attendance.history');

    // Salary
    Route::get('/salary/history', [SalaryController::class, 'history'])->name('employee.salary.history');
});
