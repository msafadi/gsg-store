<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        return Product::active()->price(200, 500)->paginate();
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $product;
    }
}
