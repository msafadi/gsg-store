<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $products = [
        'Watches' => 200,
        'T-shirts' => 50,
        'Cameras' => 230,
        'Mobiles' => 1200,
    ];

    public function index(Request $request)
    {
        echo config('app.name');

        return $this->products;
    }

    public function show($name, $category = 'Cat.')
    {
        return $category . ': ' .  $this->products[$name] ?? 'Not Found!';
    }
}
