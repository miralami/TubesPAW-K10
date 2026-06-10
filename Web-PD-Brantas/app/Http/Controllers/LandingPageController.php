<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
class LandingPageController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(4)->get();
        $serverName = config('app.server_name') ?: gethostname();

        return view('landing', compact('featuredProducts', 'serverName'));
    }

}
