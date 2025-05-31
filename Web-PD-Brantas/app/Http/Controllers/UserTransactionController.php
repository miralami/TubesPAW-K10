<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class UserTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('transactions.history', compact('transactions'));
    }
}
