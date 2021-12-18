<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Devsbuddy\AdminrCore\Http\Controllers\AdminrController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class UserController extends AdminrController
{
    protected $limit;

    public function __construct()
    {
        $this->limit = 10;
    }

    public function index()
    {
        try {
            $users = User::notRole(['admin', 'super_admin'])->paginate($this->limit);

            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }

    /**
     * Create new user
     *
     * @return mixed
     */
    public function create()
    {
        try {
            $roles = Role::get();
            return view('admin.users.create', compact('roles'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }


    /**
     * Store new user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:users'],
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'unique:users', 'numeric', 'min:10'],
            'password' => ['required', 'min:6'],
            'confirm_password' => ['required', 'same:password', 'min:6'],
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

            $user->assignRole(role($request->get('role')));

            return redirect()->route(config('app.route_prefix') . '.users.index')
                ->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }


    /**
     * Edit new user
     *
     * @param User $user
     * @return mixed
     */
    public function edit(User $user)
    {
        try {
            $roles = Role::get();
            return view('admin.users.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }


    /**
     * Store new user
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, Request $request)
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
            if ($request->hasFile('avatar')) {
                $avatar = $this->uploadFile($request->file('avatar'), 'users/avatars')->getFileName();
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

            return redirect()->route(config('app.route_prefix').'.users.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        } catch (\Error $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }


    /**
     * Delete user from database
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            if (!Str::contains($user->avatar, 'default-avatar.png')) {
                $this->deleteFileFromStorage($user->avatar);
            }
            $user->delete();
            return back()->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }


}

