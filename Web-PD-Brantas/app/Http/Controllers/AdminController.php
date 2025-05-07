<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index()
    {
        return view('admin.dashboard');
    }

    function admin()
    {
        return view('admin.dashboard');
    }

    function user()
    {
        return view('admin.dashboard');
    }
}
