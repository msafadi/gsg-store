<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StoreFrontLayout extends Component
{
    public $title;

    public $cart;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = '')
    {
        $this->cart = [];
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.store-front');
    }
}
