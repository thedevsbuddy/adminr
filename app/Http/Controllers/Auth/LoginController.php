<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(): View|RedirectResponse
    {
        try{
            return view('auth.login');
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->get('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(auth()->attempt(array($fieldType => $request->get('email'), 'password' => $request->get('password'))))
        {
            if (auth()->check() && auth()->user()->hasRole(['admin', 'super_admin'])){
                return $this->intendedSuccess(route: route(config('adminr.route_prefix').'.index'), message: "Logged In Successfully!");
            } else {
                return $this->intendedSuccess(route: route('index'), message: "Logged In Successfully!");
            }
        } else {
            return $this->backError('Email-Address And Password Are Wrong.');
        }
    }

    public function logout(): RedirectResponse
    {
        try{
            if(auth()->check()){
                auth()->logout();
                request()->session()->invalidate();

                request()->session()->regenerateToken();
            }
            /// TODO: Think where to redirect after logging out.
            return $this->redirectSuccess(route: route('auth.login'), message: "You are logged out successfully!");
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }
}
