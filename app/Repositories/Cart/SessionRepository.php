<?php

namespace App\Repositories\Cart;

use Illuminate\Support\Facades\Session;

class SessionRepository implements CartRepository
{
    protected $key = 'cart';

    public function all()
    {
        return Session::get($this->key);
    }

    public function add($item, $qty = 1)
    {
        Session::push($this->key, $item);
    }

    public function clear()
    {
        Session::forget($this->key);
    }
}