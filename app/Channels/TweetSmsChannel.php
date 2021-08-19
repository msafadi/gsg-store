<?php

namespace App\Channels;

use App\Notifications\OrderCreatedNotification;
use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class TweetSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationForTweetSms();
        $message = $notification->toTweetSms($notifiable);

        //http://www.tweetsms.ps/api.php?comm=sendsms&user=TEST&pass=123456&to=972594127070&message=testmessage&sender=TweetTEST
        // CURL
        $response = Http::baseUrl('http://www.tweetsms.ps')
            ->get('api.php', [
                'comm' => 'sendsms',
                'user' => config('services.tweetsms.user'),
                'pass' => config('services.tweetsms.password'),
                'to' => $to,
                'message' => urlencode($message),
                'sender' => config('services.tweetsms.sender'),
            ]);

        $result = $response->body();
        if ($result != 1) {
            throw new Exception('Error code: ' . $result);
        }
    
    }
}
