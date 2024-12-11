<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // panggil dashboard admin
    public function showDashboard()
    {
        return view('admin.dashboard');
    }
}
