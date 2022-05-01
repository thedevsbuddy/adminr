<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class VerificationController extends Controller
{

    public function sendEmailVerificationMail(): JsonResponse
    {
        try{
            $user = User::where('email', request('email'))->first();

            if(!$user){
                return $this->errorMessage(message: "Provided email is not registered with us.", statusCode: 200);
            }

            $user->mail(template: "email-verification-mail", replaceable: [
                "{email}" => $user->email,
                "{verify_link}" => route('auth.verify-email') . "?token=" . $this->generateTokenForUser(user: $user)->token,
            ]);

            return $this->successMessage(message: "Verification mail is sent to your email " . request('email'));

        } catch (\Exception | \Error $e){
            info($e->getMessage());
            return $this->errorMessage(message: "Something went wrong!", statusCode: 200);
        }

    }

    public function sendOtpVerificationMail(): JsonResponse|RedirectResponse
    {
        try{
            $user = User::where('email', request('email'))->first();

            if(!$user){
                return $this->errorMessage(message: "Provided email is not registered with us.", statusCode: 200);
            }

            $user->mail(template: "email-verification-otp-mail", replaceable: [
                "{email}" => $user->email,
                "{otp}" => $this->generateOtpForUser(user: $user),
            ]);

            $user->mail(template: "email-verification-otp-mail", replaceable: []);

            return $this->successMessage(message: "Verification mail is sent to your email " . request('email'));

        } catch (\Exception | \Error $e){
            info($e->getMessage());
            return $this->errorMessage(message: 'Something went wrong!', statusCode: 200);
        }

    }

    public function verifyEmail(): JsonResponse
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
            return $this->errorMessage(message: "Sorry your email cannot be identified.", statusCode: 200);
        }

        return $this->successMessage(message: $message);
    }

    public function verifyOtp(): JsonResponse
    {
        try{
            $user = User::where('email', request('email'))->first();

            if(!$user){
                return $this->errorMessage(message: "Provided email is not registered with us.", statusCode: 200);
            }

            if($user->otp != request('otp')){
                return $this->errorMessage(message: "Verification code is invalid.", statusCode: 200);
            }

            $user->update([
                "email_verified_at" => now(),
            ]);

            $user->mail(template: "email-verification-success-mail", replaceable: [
                "{login_link}" => route('auth.login'),
            ]);

            return $this->successMessage(message: "Account verified successfully!");
        } catch (\Exception | \Error $e){
            info($e->getMessage());
            return $this->errorMessage('Something went wrong!');
        }
    }

}
