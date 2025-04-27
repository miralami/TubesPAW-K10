<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = [
            [
                'name' => 'Topi Polisi',
                'price' => 50000,
                'sold' => '1.5rb',
                'likes' => 126,
                'image' => 'https://img.lazcdn.com/g/ff/kf/S28d70087c4e04a52a72a825f99e9c33cO.jpg_720x720q80.jpg'
            ],
            // Add more dummy products here
        ];

        return view('products.index', compact('products'));
    }
}
