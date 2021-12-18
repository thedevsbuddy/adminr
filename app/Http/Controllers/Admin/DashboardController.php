<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Devsbuddy\AdminrCore\Http\Controllers\AdminrController;
use Illuminate\Http\Request;

class DashboardController extends AdminrController
{
    public function index()
    {
        try{
            $usersCount = User::notRole(['super_admin', 'admin'])->count();
            return view('admin.dashboard.index', compact('usersCount'));
        } catch (\Exception $e){
            return back()->with('error', 'Error: ' . $e->getMessage());
        } catch (\Error $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }
}
