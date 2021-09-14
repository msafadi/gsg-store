<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\SendReminderMailNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendReminderMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::whereNull('email_verified_at')
            ->whereDate('created_at', '<=', Carbon::now()->subDays(7))
            ->chunk(100, function($users) {
                $i = 0;
                foreach($users as $user) {
                    $user->notify(new SendReminderMailNotification)->delay(now()->addMinutes($i));
                    $i++;
                }
                Notification::send($users, new SendReminderMailNotification);

            });
        
    }
}
