<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        return view('admin.notifcations', [
            'notifications' => $user->notifications()->paginate(),
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $notifciation = $user->notifications()->findOrFail($id);

        $notifciation->markAsRead();

        if (isset($notifciation->data['url']) && $notifciation->data['url']) {
            return redirect($notifciation->data['url']);
        }

        return redirect()->back();
    }
}
