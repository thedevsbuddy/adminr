<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Mail\TestMailQueued;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailTestController extends Controller
{
    public function send(): RedirectResponse
    {
        try{
            if((int)getSetting('mail_queue_enabled')){
                Mail::to(request('email'))->send(new TestMailQueued());
            } else {
                Mail::to(request('email'))->send(new TestMail());
            }
            return $this->backSuccess(message: 'Mail send successfully!');
        } catch (\Exception | \Error $e){
            info($e->getMessage());
            return $this->backError(message: 'Something went wrong!');
        }
    }
}
