<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionController extends Controller
{
    public function index(): View|RedirectResponse
    {
        try{
            $roles = Role::all();
            $permissions = Permission::whereNull('resource')->get();

            return view('adminr.roles-and-permissions.index', compact('roles', 'permissions'));
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    public function assignPermission(Request $request): JsonResponse
    {

        $role = Role::where('id', $request->get('role_id'))->first();
        $permission = Permission::where('id', $request->get('permission_id'))->first();

        if(!$role->hasPermissionTo($permission)){
            $role->givePermissionTo($permission);
        }
        return $this->successMessage('Permission assigned to '.$role->name.' !');
    }

        public function revokePermission(Request $request): JsonResponse
    {

        $role = Role::where('id', $request->get('role_id'))->first();
        $permission = Permission::where('id', $request->get('permission_id'))->first();

        if($role->hasPermissionTo($permission)){
            $role->revokePermissionTo($permission);
        }
        return $this->successMessage('Permission revoked from '.$role->name.' !');
    }


    public function storeRole(Request $request): RedirectResponse
    {
        $request->validate([
           'name' => ['required', 'unique:roles'],
        ], [
            "name.unique" => "Role with name \"".$request->get('name')."\" already exist."
        ]);
        try{
            Role::create([
                'name' => $request->get('name')
            ]);
            return $this->backSuccess('Role created successfully!');
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }

    public function storePermission(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'unique:permissions'],
        ], [
            "name.unique" => "Permission with name \"".$request->get('name')."\" already exist."
        ]);
        try{
            Permission::create([
                'name' => $request->get('name')
            ]);
            return $this->backSuccess('Permission created successfully!');
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }
}
