<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendReminderMailJob;
use Illuminate\Http\Request;

class SendEmailsController extends Controller
{
    public function send()
    {
        //dispatch(new SendReminderMailJob($model))->onQueue('mail');
        SendReminderMailJob::dispatch()->onQueue('mail');
        return 'Done!';
    }
}
