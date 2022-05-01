<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailTestController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        try{

            if((int)getSetting('mail_queue_enabled')){
                Mail::to($request->get('email'))->send(new \App\Mail\TestMailQueued());
            } else {
                Mail::to($request->get('email'))->send(new \App\Mail\TestMail());
            }

            return $this->backSuccess(message: 'Mail send successfully!');
        } catch (\Exception $e){
            return $this->backError(message: 'Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError(message: 'Error: ' . $e->getMessage());
        }
    }
}
