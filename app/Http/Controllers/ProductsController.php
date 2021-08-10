<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::active()->paginate();
        return view('front.products.index', [
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', '=', $slug)->firstOrFail();
        return view('front.products.show', [
            'product' => $product,
        ]);
    }
}
