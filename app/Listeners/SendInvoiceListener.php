<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderInvoice;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendInvoiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        $users = User::whereIn('type', ['super-admin', 'admin'])->get();
        /*foreach ($users as $user) {
            $user->notify( new OrderCreatedNotification($order) );
        }*/
        Notification::send($users, new OrderCreatedNotification($order) );

        //Notification::route('mail', ['info@example.com', 'admin@example.com'])
            //->route('nexmo', '+97059885474')
            //->notify( new OrderCreatedNotification($order) );
        
        //Mail::to($order->billing_email)->send(new OrderInvoice($order));
    }
}
