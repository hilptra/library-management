<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function admin() {
        return view('admin.dashboard');
    }

    public function member() {
        return view('member.dashboard');
    }
}
