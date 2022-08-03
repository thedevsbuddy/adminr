<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    protected int $limit;

    public function __construct()
    {
        $this->limit = 10;
    }

    public function index(): View|RedirectResponse
    {
        try {
            $users = User::notRole(['admin', 'super_admin'])->paginate($this->limit);

            return view('adminr.users.index', compact('users'));
        } catch (\Exception $e) {
            return $this->backError('Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return $this->backError('Error : ' . $e->getMessage());
        }
    }

    public function create(): View|RedirectResponse
    {
        try {
            $roles = Role::where('name', '!=', 'super_admin')->get();
            return view('adminr.users.create', compact('roles'));
        } catch (\Exception $e) {
            return $this->backError('Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return $this->backError('Error : ' . $e->getMessage());
        }
    }



    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required'],
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'unique:users', 'numeric', 'min:10'],
            'password' => ['required', 'min:6'],
            'confirm_password' => ['required', 'same:password', 'min:6'],
        ]);

        try {
            if ($request->hasFile('avatar')) {
                $avatar = $this->uploadFile(file: $request->file('avatar'), dir: 'users/avatars')->getFilePath();
            } else {
                $avatar = null;
            }

            $user = User::create([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'avatar' => $avatar,
                'email_verified_at' => now(),
                'password' => bcrypt($request->get('password')),
            ]);

            $user->assignRole(Role::where('id', $request->get('role'))->first());

            return $this->redirectSuccess(route(config('adminr.route_prefix') . '.users.index'), 'User created successfully!');
        } catch (\Exception $e) {
            return $this->backError('Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return $this->backError('Error : ' . $e->getMessage());
        }
    }


    public function edit(User $user): View|RedirectResponse
    {
        try {
            $roles = Role::where('name', '!=', 'super_admin')->get();
            return view('adminr.users.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return $this->backError('Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return $this->backError('Error : ' . $e->getMessage());
        }
    }



    public function update(User $user, Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required'],
            'username' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'numeric', 'min:10'],
            'password' => ['sometimes'],
            'confirm_password' => ['sometimes', 'same:password'],
        ]);

        try {
            // Validate if username admin entered is of
            // selected user or any one else took it
            if(User::where('username', $request->get('username'))->where('id', '!=', $user->id)->value('id') != null){
                return  $this->backError(message: "Username is already taken!");
            }

            if ($request->hasFile('avatar')) {
                $avatar = $this->uploadFile($request->file('avatar'), 'users/avatars')->getFilePath();
                $this->deleteStorageFile($user->avatar);
            } else {
                $avatar = $user->avatar;
            }

            $user->update([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'avatar' => $avatar,
            ]);

            if ($request->get('password') && $request->get('confirm_password')) {
                $user->update([
                    'password' => bcrypt($request->get('password'))
                ]);
            }

            // Update User role if selected new
            $user->syncRoles(Role::where('id', $request->get('role'))->first());

            return $this->redirectSuccess(route(config('adminr.route_prefix').'.users.index'), 'User updated successfully!');
        } catch (\Exception $e) {
            return $this->backError('Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return $this->backError('Error : ' . $e->getMessage());
        }
    }


    public function destroy(User $user): RedirectResponse
    {
        try {
            if (!Str::contains($user->avatar, 'default-avatar.png')) {
                $this->deleteStorageFile($user->avatar);
            }
            $user->delete();
            return $this->backSuccess('User deleted successfully!');
        } catch (\Exception $e) {
            return $this->backError('Error : ' . $e->getMessage());
        }
    }


}

