<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        try{
            $usersCount = User::notRole(['super_admin', 'admin'])->count();
            return view('adminr.dashboard.index', compact('usersCount'));
        } catch (\Exception | \Error $e){
            adminr()->log($e);
            return $this->backError('Error: ' . $e->getMessage());
        }
    }
}
