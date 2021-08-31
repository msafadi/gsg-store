<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as FortifyLoginResponse;

class LoginResponse implements FortifyLoginResponse
{

    public function toResponse($request)
    {
        if ($request->user()->type == 'user') {
            return redirect()->intended('/');
        }

        return redirect()->intended('/dashbaord');
    }
}