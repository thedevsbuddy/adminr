<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Devsbuddy\AdminrEngine\Http\Controllers\AdminrController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthController extends AdminrController
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'identifier' => 'required|string|',
            'password' => 'required|string'
        ]);

        $fieldType = filter_var($request->get('identifier'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (!Auth::attempt([$fieldType => $request->get('identifier'), "password" => $request->get('password')])) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'message' => 'Logged In successfully!',
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
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

            $user = User::create([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'avatar' => $avatar,
                'password' => bcrypt($request->get('password')),
            ]);
            $user->syncRoles(Role::where('name', 'user')->first()->id);

            return $this->successMessage("Registration was successfully!");
        } catch (\Exception $e) {
            return $this->error('Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return $this->error('Error : ' . $e->getMessage());
        }
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            "email"     => ["required", "string", "email"],
        ]);

        $user = User::where('email', $request->get('email'))->first();
        if(!$user){
            return $this->error("User not registered with this email!");
        }
        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,
        ]);

        return $this->successMessage("Logged out successfully!");
    }


    public function resetPassword(Request $request)
    {

    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->successMessage("Logged out successfully!");
    }
}
