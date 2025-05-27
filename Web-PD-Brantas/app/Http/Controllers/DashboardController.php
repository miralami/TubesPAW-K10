<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user         = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->route('landing.index');
        }

        // stat cards
        $productCount = Product::count();
        $userCount    = User::count();
        $todayOrders  = Transaction::whereDate('created_at', Carbon::today())->count();

        // total semua produk terjual
        $soldCount    = Product::sum('sold');

        // Top 5 produk terlaris
        $topProducts  = Product::orderBy('sold','desc')
                               ->take(5)
                               ->get(['name','sold']);

        // kirim semua ke view
        return view('admin.dashboard', compact(
            'user',
            'productCount',
            'userCount',
            'todayOrders',
            'soldCount',
            'topProducts'
        ));
    }
}
