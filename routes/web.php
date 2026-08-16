<?php
use App\Http\Controllers\CalculatorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CalculatorController::class,'index'])->name('home');
Route::get('/calculator/{slug}', [CalculatorController::class,'show'])->name('calculator.show');
Route::post('/calculator/{slug}', [CalculatorController::class,'calculate'])->name('calculator.calculate');
