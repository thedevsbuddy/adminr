<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegisterForm(): View|RedirectResponse
    {
        try {
            return view('auth.register');
        } catch (\Exception $e) {
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e) {
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => ['required'],
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'unique:users'],
            'password' => ['required', 'confirm'],
        ]);

        try {
            $user = User::create([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'password' => bcrypt($request->get('password')),
            ]);

            $user->syncRoles(Role::where('name', 'user')->first()->id);

            auth()->login($user);

            return $request->wantsJson()
                ? $this->successMessage(message: "Registered successfully!")
                : $this->redirectSuccess(route: route('index'), message: "Registered successfully!");

        } catch (\Exception $e) {
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e) {
            return $this->backError('Error: ' . $e->getMessage());
        }

    }
}
