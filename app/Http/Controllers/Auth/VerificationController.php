<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationToken;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class VerificationController extends Controller
{

    public function index(): View|RedirectResponse
    {
        try{
            return view('auth.verify');
        } catch (\Exception | \Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    public function sendVerificationMail(): RedirectResponse
    {
        try{
            $user = User::where('email', request('email'))->first();

            $user->mail(template: "registration-welcome-mail", replaceable: []);

            return  $this->backSuccess(message: "Verification mail is sent to your email " . request('email'));

        } catch (\Exception | \Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }

    }

    public function verifyEmail(): RedirectResponse
    {
        $verifyUser = VerificationToken::where('token', request('token'))
            ->with('user')
            ->first();

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
            if(is_null($user->email_verified_at)) {

                $user->update([
                    "email_verified_at" => now(),
                ]);

                $message = "Your e-mail is verified. You can now login to your account.";
            } else {
                $message = "Your e-mail is already verified. You can login to your account.";
            }

            $user->mail(template: "email-verification-success-mail", replaceable: [
                "{login_link}" => route('auth.login'),
            ]);

            // Delete token after successful verification.
            $verifyUser->delete();

        } else {
            return $this->redirectError(route: route('auth.login'), message: 'Sorry your email cannot be identified.');
        }
        return $this->redirectSuccess(route: route('auth.login'), message: $message);
    }

}
