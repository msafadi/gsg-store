<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->route('lang');
        if ($lang) {
            App::setLocale($lang);
            //session()->put('lang', $lang);
        }

        URL::defaults([
            'lang' => App::currentLocale(),
        ]);
        
        Route::current()->forgetParameter('lang');

        return $next($request);
    }
}
