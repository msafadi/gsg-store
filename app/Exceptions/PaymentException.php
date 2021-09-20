<?php

namespace App\Exceptions;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaymentException extends Exception
{

    /**
     * @var \App\Models\Order
     */
    protected $order;
    
    public function setOrder(Order $order)
    {
        $this->order = $order;
        return $this;
    }

    public function render(Request $request)
    {
        return redirect('admin/categories')
                ->with('error', $this->getMessage());
    }

    public function report()
    {
        Log::error('Payment failed!');
    }
}
