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
        try {
            return view('auth.verify');
        } catch (\Exception | \Error $e) {
            info($e->getMessage());
            return $this->backError('Something went wrong!');
        }
    }

    public function sendEmailVerificationMail(): RedirectResponse
    {
        try {
            $user = User::where('email', request('email'))->first();

            if (!$user) {
                return $this->backError(message: "Provided email is not registered with us.");
            }

            $user->mail(template: "email-verification-mail", replaceable: [
                "{email}" => $user->email,
                "{verify_link}" => route('auth.verify-email') . "?token=" . $this->generateTokenForUser(user: $user)->token,
            ]);

            return $this->backSuccess(message: "Verification mail is sent to your email " . request('email'));

        } catch (\Exception | \Error $e) {
            info($e->getMessage());
            return $this->backError('Something went wrong!');
        }

    }

    public function sendOtpVerificationMail(): RedirectResponse
    {
        try {
            $user = User::where('email', request('email'))->first();

            if (!$user) {
                return $this->backError(message: "Provided email is not registered with us.");
            }

            $user->mail(template: "email-verification-otp-mail", replaceable: [
                "{email}" => $user->email,
                "{otp}" => $this->generateOtpForUser(user: $user),
            ]);

            $user->mail(template: "email-verification-otp-mail", replaceable: []);

            return $this->backSuccess(message: "Verification mail is sent to your email " . request('email'));

        } catch (\Exception | \Error $e) {
            info($e->getMessage());
            return $this->backError('Something went wrong!');
        }

    }

    public function verifyEmail(): RedirectResponse
    {
        $verifyUser = VerificationToken::where('token', request('token'))
            ->with('user')
            ->first();
        
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (is_null($user->email_verified_at)) {

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
            return $this->redirectError(route: route('auth.login'), message: "Sorry your email cannot be identified.");
        }
        return $this->redirectSuccess(route: route('auth.login'), message: $message);
    }

    public function verifyOtp(): RedirectResponse
    {
        $user = User::where('email', request('email'))->first();

        if (!$user) {
            return $this->backError(message: "Provided email is not registered with us.");
        }

        if ($user->otp != request('otp')) {
            return $this->backError(message: "Verification code is invalid.");
        }

        $user->update([
            "email_verified_at" => now(),
        ]);

        $user->mail(template: "email-verification-success-mail", replaceable: [
            "{login_link}" => route('auth.login'),
        ]);

        return $this->redirectSuccess(route: route('auth.login'), message: "Account verified successfully");
    }

}
