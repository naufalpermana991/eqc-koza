<?php

use Illuminate\Support\Facades\Route;

/**
 * Authentication
 *
 **/
use App\Http\Controllers\auth\Login;

Route::prefix('auth')->group(function() {
	Route::get('/login', [Login::class, 'index'])->name('auth.login_form');
	Route::post('/login', [Login::class, 'index'])->name('auth.login_action');
	Route::get('/logout', [Login::class, 'logout'])->name('auth.logout');
});

/**
 * Launcher
 *
 **/
use App\Http\Controllers\Dashboard;

Route::get('/', [Dashboard::class, 'index'])->name('dashboard')->middleware(['verify']);
Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard')->middleware(['verify']);
Route::get('/dashboard/show_excel', [Dashboard::class, 'showExcel'])->name('dashboard.show_excel')->middleware(['verify']);

// =================================== Module Quality Control =============================================
use App\Http\Controllers\Inspection;
use App\Http\Controllers\Validation;
use App\Http\Controllers\ValidationHistory;
use App\Http\Controllers\Users;
use App\Http\Controllers\Customer;
Route::middleware(['verify'])->prefix('inspection')->group(function() {
	Route::get('/', [Inspection::class, 'index'])->name('inspection.list');
	Route::get('/get_data_inspection', [Inspection::class, 'getDataInspection'])->name('inspection.get_data_inspection');
	Route::get('/convert_image', [Inspection::class, 'convertImage'])->name('inspection.convert_image');
	Route::get('/delete_data', [Inspection::class, 'deleteData'])->name('inspection.delete_data');
	Route::get('/show', [Inspection::class, 'showData'])->name('inspection.show');
	Route::post('/create', [Inspection::class, 'create'])->name('inspection.create');
});

Route::middleware(['verify'])->prefix('customer')->group(function() {
	Route::get('/', [Customer::class, 'index'])->name('customer.list');
	Route::get('/get_data', [Customer::class, 'getData'])->name('customer.get_data');
	Route::get('/delete_data', [Customer::class, 'deleteData'])->name('customer.delete_data');
	Route::post('/create', [Customer::class, 'create'])->name('customer.create');
	Route::post('/update', [Customer::class, 'update'])->name('customer.update');
});

Route::middleware(['verify'])->prefix('validation')->group(function() {
	Route::get('/', [Validation::class, 'index'])->name('validation.list');
	Route::get('/list', [Validation::class, 'index'])->name('validation.list_data');
	Route::get('/checked_file', [Validation::class, 'checkedFile'])->name('validation.checked_file');
	Route::get('/show', [Validation::class, 'showData'])->name('validation.show');
	Route::get('/download', [Validation::class, 'downloadData'])->name('inspection.download');
	Route::post('/checked_file_batch', [Validation::class, 'checkedFileBatch'])->name('validation.checked_file_batch');
});

Route::middleware(['verify'])->prefix('val_history')->group(function() {
	Route::get('/', [ValidationHistory::class, 'index'])->name('val_history.list');
	Route::get('/list', [ValidationHistory::class, 'index'])->name('val_history.list_data');
	Route::get('/get_data_history', [ValidationHistory::class, 'getDataHistory'])->name('val_history.get_data_history');
	Route::get('/export_excel', [ValidationHistory::class, 'exportExcel'])->name('val_history.export_excel');
	Route::get('/show', [ValidationHistory::class, 'showData'])->name('val_history.show');
});

Route::middleware(['verify'])->prefix('user')->group(function() {
	Route::get('/', [Users::class, 'index'])->name('user.list');
	Route::get('/get_data', [Users::class, 'getData'])->name('user.get_data');
	Route::get('/get_profile', [Users::class, 'getProfile'])->name('user.get_profile');
	Route::post('/change_password', [Users::class, 'changePassword'])->name('user.change_password');
	Route::post('/update_profile', [Users::class, 'updateProfile'])->name('user.update_profile');
	Route::post('/create', [Users::class, 'create'])->name('user.create');
	Route::post('/update', [Users::class, 'update'])->name('user.update');
	Route::get('/delete_data', [Users::class, 'deleteData'])->name('user.delete_data');
});
