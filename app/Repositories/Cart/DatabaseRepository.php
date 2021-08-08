<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DatabaseRepository implements CartRepository
{
    public function all()
    {
        return Cart::where('cookie_id', $this->getCookieId())
            ->orWhere('user_id', Auth::id())
            ->get();
    }

    public function add($item, $qty = 1)
    {
        return Cart::create([
            'id' => Str::uuid(),
            'cookie_id' => $this->getCookieId(),
            'product_id' => ($item instanceof Product)? $item->id : $item,
            'user_id' => Auth::id(),
            'quantity' => $qty,
        ]);
    }

    public function clear()
    {
        Cart::where('cookie_id', $this->getCookieId())
            ->orWhere('user_id', Auth::id())
            ->delete();
    }

    protected function getCookieId()
    {
        $id = Cookie::get('cart_cookie_id');
        if (!$id) {
            $id = Str::uuid();
            Cookie::queue('cart_cookie_id', $id, 60 * 24 * 30);
        }

        return $id;
    }

}
