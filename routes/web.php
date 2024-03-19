<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // dashboard route
    require __DIR__ . '/backend/dashboard/dashboard_route.php';

    //user route
    require __DIR__ . '/backend/user/user_route.php';

    //profile route
    require __DIR__ . '/backend/user/profile/profile_route.php';
});

//auth route
require __DIR__ . '/backend/auth/auth.php';
