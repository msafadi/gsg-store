<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('chat');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);

        // Save message in database

        broadcast(new MessageSent($request->message, Auth::user()));

        return;
    }
}
