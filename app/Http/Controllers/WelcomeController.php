<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    // Actions
    public function welcome()
    {
        return view('welcome');
    }
}
