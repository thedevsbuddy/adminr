<?php

namespace Devsbuddy\AdminrEngine\Http\Controllers;

use App\Http\Controllers\Controller;
use Devsbuddy\AdminrEngine\Models\AdminrResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolePermissionController extends Controller
{
    public function getRoles(): JsonResponse
    {
        return $this->success(Role::select('id', 'name')
            ->whereNotIn('name', ['developer', 'super_admin'])
            ->get(), 200);
    }

    public function getPermissions($id): JsonResponse
    {
        $resource = AdminrResource::where('id', $id)->first();
        $permissions = $this->success(Permission::select('id', 'name')
            ->where('resource', strtolower($resource->id))
            ->orderBy('name', 'ASC')
            ->with(['roles:id'])
            ->get(), 200);

        return $permissions;
    }

    public function assignPermissionsToRoles(Request $request): JsonResponse
    {
        foreach(json_decode($request->get('permissions')) as $r => $p){
            $role = Role::where('name', json_decode($r))->first();
            $rolePermissionsToRemove = $role->getAllPermissions()
                ->where('resource', strtolower($request->get('resource')))->whereNotIn('id', $p)->pluck('id')->toArray();
            $permissions = Permission::where('resource', strtolower($request->get('resource')))->pluck('id')->toArray();

            foreach ($permissions as $permission){
                if(in_array($permission, $p) && !in_array($permission, $rolePermissionsToRemove)){
                    $role->givePermissionTo($permission);
                }
            }
            foreach ($rolePermissionsToRemove as $rolePermissionToRemove){
                $role->revokePermissionTo($rolePermissionToRemove);
            }
        }

        return $this->successMessage('Role and permissions assigned!');
    }

}

