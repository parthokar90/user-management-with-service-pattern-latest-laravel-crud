<?php

namespace App\Http\Controllers\backend\dashboard;

use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function index(){
        return view('backend.dashboard.index');
    }
}
