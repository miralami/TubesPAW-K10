<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
{
    $productCount = Product::count();
    $userCount = User::where('role', 'user')->count();

    return view('admin.dashboard', compact('productCount', 'userCount'));
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
