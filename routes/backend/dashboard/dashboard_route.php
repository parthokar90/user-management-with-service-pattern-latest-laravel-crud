<?php

use App\Http\Controllers\backend\dashboard\DashboardController;

use Illuminate\Support\Facades\Route;

// dashboard route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
