<?php
use App\Http\Controllers\AdminAccessController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CalculatorController::class,'index'])->name('home');
Route::get('/calculator/{slug}', [CalculatorController::class,'show'])->name('calculator.show');
Route::post('/calculator/{slug}', [CalculatorController::class,'calculate'])->name('calculator.calculate');

Route::get('/setup', [SetupController::class, 'show'])->name('setup.show');
Route::post('/setup', [SetupController::class, 'store'])->name('setup.store');

Route::get('/admin-access', [AdminAccessController::class, 'show'])->name('admin-access.show');
Route::post('/admin-access', [AdminAccessController::class, 'store'])->name('admin-access.store');
