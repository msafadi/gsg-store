<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    /**
     * @var \App\Repositories\Cart\CartRepository;
     */
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    public function create()
    {
        return view('front.checkout', [
            'cart' => $this->cart,
            'user' => Auth::user(),
            'countries' => Countries::getNames(App::currentLocale()),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'billing_name' => ['required', 'string'],
            'billing_phone' => 'required',
            'billing_email' => 'required|email',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_country' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $request->merge([
                'total' => $this->cart->total(),
            ]);
            $order = Order::create($request->all());
            
            $items = [];
            foreach ($this->cart->all() as $item) {
                $items[] = [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ];

                /*$order->items()->create([
                    //'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);*/

                /*$order->products()->attach($item->product_id, [
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);*/
            }
            DB::table('order_items')->insert($items);

            DB::commit();

            //event('order.created', $order); // $order passed to the listener
            event(new OrderCreated($order)); // $event passed to the listener

            // delete cart
            // send invoice
            // send notification to admin

            return redirect()->route('orders')->with('success', __('Order created.'));
            
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
