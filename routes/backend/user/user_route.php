<?php

use App\Http\Controllers\backend\user\UserController;

use Illuminate\Support\Facades\Route;

//user route
Route::resource('users', UserController::class);

//trash user route
Route::get('/trash/user', [UserController::class, 'trash'])->name('trash.user');

//restore user route
Route::post('/user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');

//permanent delete route
Route::delete('user/{id}/permanent-delete', [UserController::class, 'permanentDelete'])->name('user.permanent-delete');
