<?php

namespace App\Notifications;

use App\Channels\TweetSmsChannel;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // mail, database, nexmo (SMS), broadcast, slack, [Custom channel]

        $via = [
            'database',
            FcmChannel::class,
            //'mail', 'broadcast', 'nexmo'
            //TweetSmsChannel::class
        ];
        /*if ($notifiable->notify_sms) {
            $via[] = 'nexmo';
        }
        if ($notifiable->notify_mail) {
            $via[] = 'mail';
        }*/
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(__('New Order #:number', ['number' => $this->order->number]))
                    ->from('billing@localhost', 'GSG Billing')
                    ->greeting( __('Hello, :name', ['name' => $notifiable->name ?? '']) )
                    ->line( __('A new order has been created (Order #:number).', [
                        'number' => $this->order->number,
                    ]) )
                    ->action('view Order', url('/'))
                    ->line('Thank you for shopping with us!')
                    /*->view('', [
                        'order' => $this->order,
                    ])*/;
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => __('New Order #:number', ['number' => $this->order->number]),
            'body' => __('A new order has been created (Order #:number).', [
                'number' => $this->order->number,
            ]),
            'icon' => '',
            'url' => url('/'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => __('New Order #:number', ['number' => $this->order->number]),
            'body' => __('A new order has been created (Order #:number).', [
                'number' => $this->order->number,
            ]),
            'icon' => '',
            'url' => url('/'),
            'time' => Carbon::now()->diffForHumans(),
        ]);
    }

    public function toNexmo($notifiable)
    {
        $message = new NexmoMessage();
        $message->content(__('New Order #:number', ['number' => $this->order->number]));
        return $message;
    }

    public function toTweetSms($notifiable)
    {
        return __('New Order #:number', ['number' => $this->order->number]);
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData([
                'order_id' => $this->order->id,
            ])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle(__('New Order'))
                ->setBody(__('New Order #:number', ['number' => $this->order->number]))
                ->setImage('http://example.com/url-to-image-here.png'))
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
