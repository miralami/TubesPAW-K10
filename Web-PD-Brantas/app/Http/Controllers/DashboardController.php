<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $user = Auth::user();

        // Cegah akses user biasa ke /dashboard
        if ($user->role !== 'admin') {
            return redirect()->route('landing.index');
        }

        return view('admin.dashboard', compact('user'));
    }

}
