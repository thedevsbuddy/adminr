<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'identifier' => 'required|string|',
                'password' => 'required|string'
            ]);

            $fieldType = filter_var($request->get('identifier'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            if (!Auth::attempt([$fieldType => $request->get('identifier'), "password" => $request->get('password')])) {
                return $this->errorMessage('Credentials not match', 401);
            }

            return $this->success(data: [
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('API Token')->plainTextToken
            ], message: "Logged In successfully!");
        } catch (\Exception | \Error $e) {
            info($e->getMessage());
            return $this->errorMessage(message: 'Something went wrong!', statusCode: 200);
        }
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required'],
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'unique:users', 'numeric', 'min:10'],
            'password' => ['required', 'min:6'],
        ]);

        try {
            if ($request->hasFile('avatar')) {
                $avatar = $this->uploadFile($request->file('avatar'), 'users/avatars')->getFileName();
            } else {
                $avatar = null;
            }

            $otp = rand(100000, 999999);

            $user = User::create([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'avatar' => $avatar,
                'otp' => $otp,
                'password' => bcrypt($request->get('password')),
            ]);
            $user->syncRoles(Role::where('name', 'user')->first()->id);

            // Check if verification enabled and send verification mail
            if (!is_null(getSetting('email_verification_enabled')) && (int)getSetting('email_verification_enabled')) {
                $user->mail(template: "registration-email-verification-with-otp-mail", replaceable: [
                    "{name}" => $user->name,
                    "{username}" => $user->username,
                    "{email}" => $user->email,
                    "{otp}" => $otp,
                ]);
            } else {
                // Send welcome mail if verification is disabled
                $user->mail(template: "registration-welcome-mail", replaceable: [
                    "{name}" => $user->name,
                    "{username}" => $user->username,
                    "{email}" => $user->email,
                ]);
            }
            return $this->successMessage("Registration was successful!");
        } catch (\Exception $e) {
            return $this->errorMessage('Something went wrong!');
        } catch (\Error $e) {
            info($e->getMessage());
            return $this->errorMessage('Something went wrong!');
        }
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        try {
            $request->validate([
                "email" => ["required", "string", "email"],
            ]);

            $user = User::where('email', $request->get('email'))->first();
            if (!$user) {
                return $this->errorMessage("User not registered with this email!");
            }
            $otp = rand(100000, 999999);
            $user->update([
                'otp' => $otp,
            ]);

            $user->mail(template: "email-verification-otp-mail", replaceable: [
                "{email}" => $user->email,
                "{otp}" => $otp,
            ]);

            return $this->successMessage("Otp sent successfully!");
        } catch (\Exception | \Error $e) {
            info($e->getMessage());
            return $this->errorMessage(message: 'Something went wrong!', statusCode: 200);
        }
    }

    public function resetPassword(Request $request): JsonResponse
    {
        try {
            // Default basic validations
            $request->validate([
                "password" => ["required", "string"],
                "confirm_password" => ["required", "string"],
            ]);

            // Check if password matches
            if ($request->get('password') != $request->get('confirm_password')) {
                return $this->errorMessage("Password do not match with confirm password!", 200);
            }

            // Update user password
            auth()->user()->update([
                'password' => bcrypt($request->get('password')),
            ]);

            // Notify user via email
            auth()->user()->mail(template: "password-updated-mail", replaceable: [
                "{email}" => auth()->user()->email,
                "{login_link}" => route('auth.login'),
            ]);

            // Send success response
            return $this->successMessage("Password updated successfully!");
        } catch (\Exception | \Error $e) {
            info($e->getMessage());
            return $this->errorMessage('Something went wrong!', 200);
        }
    }

    public function verifyOtp(): JsonResponse
    {
        try {
            $user = User::where('email', request('email'))->first();

            if (!$user) {
                return $this->errorMessage(message: "Provided email is not registered with us.");
            }

            if ($user->otp != request('otp')) {
                return $this->errorMessage(message: "Verification code is invalid.");
            }

            $user->update([
                "email_verified_at" => now(),
            ]);

            $user->mail(template: "email-verification-success-mail", replaceable: [
                "{login_link}" => route('auth.login'),
            ]);

            return $this->successMessage("Otp Verified successfully!");
        } catch (\Exception | \Error $e) {
            info($e->getMessage());
            return $this->errorMessage('Something went wrong!', 200);
        }
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->successMessage("Logged out successfully!");
    }
}
