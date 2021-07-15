<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()
            ->active()
            ->price(200, 500)
            ->limit(10)
            ->get();
            
        return view('home', [
            'products' => $products,
        ]);
    }
}
