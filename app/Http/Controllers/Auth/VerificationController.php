<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerificationToken;
use Illuminate\Http\RedirectResponse;

class VerificationController extends Controller
{

    public function index()
    {

    }

    public function sendVerificationMail()
    {

    }

    public function verifyEmail(): RedirectResponse
    {
        $verifyUser = VerificationToken::where('token', request('token'))
            ->with('user')
            ->first();

        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

        return redirect()->route('login')->with('message', $message);
    }

}
