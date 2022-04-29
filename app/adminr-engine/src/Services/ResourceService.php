<?php

namespace Devsbuddy\AdminrEngine\Services;

use App\Models\User;
use Devsbuddy\AdminrEngine\Models\Menu;
use Devsbuddy\AdminrEngine\Models\AdminrResource;
use Devsbuddy\AdminrEngine\Traits\CanManageFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ResourceService
{
    use CanManageFiles;

    public $id;

    public function store(Request $request): static
    {
        $resource = AdminrResource::firstOrcreate([
            'name' => Str::title(Str::plural($request->get('model'))),
            'model' => Str::studly(Str::singular($request->get('model'))),
            'table_structure' => $request->get('migrations'),
        ]);


        Permission::firstOrcreate([
            'name' => strtolower($resource->name) . '_list',
            'resource' => $resource->id
        ]);
        Permission::firstOrcreate([
            'name' => strtolower($resource->name) . '_single',
            'resource' => $resource->id
        ]);
        Permission::firstOrcreate([
            'name' => strtolower($resource->name) . '_create',
            'resource' => $resource->id
        ]);
        Permission::firstOrcreate([
            'name' => strtolower($resource->name) . '_edit',
            'resource' => $resource->id
        ]);
        Permission::firstOrcreate([
            'name' => strtolower($resource->name) . '_store',
            'resource' => $resource->id
        ]);
        Permission::firstOrcreate([
            'name' => strtolower($resource->name) . '_update',
            'resource' => $resource->id
        ]);
        Permission::firstOrcreate([
            'name' => strtolower($resource->name) . '_destroy',
            'resource' => $resource->id
        ]);

        if ($request->get('softdeletes')) {
            Permission::firstOrcreate([
                'name' => strtolower($resource->name) . '_restore',
                'resource' => $resource->id
            ]);
            Permission::firstOrcreate([
                'name' => strtolower($resource->name) . '_force_destroy',
                'resource' => $resource->id
            ]);
        }

        $permissions = Permission::where('resource', $resource->id)->get();
        $admin = Role::where('name', 'admin')->first();
        foreach ($permissions as $permission){
            $admin->givePermissionTo($permission);
        }

        $this->id = $resource->id;


        return $this;
    }

    public function update(array $data): static
    {
        AdminrResource::where('id', $this->id)->update($data);
        return $this;
    }

    public function rollback($id = null): static
    {
        if ($id == null) {
            $id = $this->id;
        }
        $resource = AdminrResource::where('id', $id)->first();

        if (isset($resource) && !is_null($resource)) {
            if (isset($resource->payload->model) && !is_null($resource->payload->model)) {
                $this->deleteFile(base_path() . '/app/Models/' . $resource->payload->model);
            }
            if (isset($resource->name) && !is_null($resource->name)) {
                $this->deleteDir(base_path() . '/resources/views/admin/' . $resource->name);
                $this->deleteDir(base_path() . '/routes/adminr/api/' . Str::lower($resource->name));
                $this->deleteDir(base_path() . '/routes/adminr/admin/' . Str::lower($resource->name));
            }
            if (isset($resource->payload->migration) && !is_null($resource->payload->migration)) {
                $this->deleteFile(base_path() . '/database/migrations/' . $resource->payload->migration);
            }
            if (isset($resource->payload->controllers->admin) && !is_null($resource->payload->controllers->admin)) {
                $this->deleteFile(base_path() . '/app/Http/Controllers/Admin/' . $resource->payload->controllers->admin);
            }
            if (isset($resource->payload->controllers->api) && !is_null($resource->payload->controllers->api)) {
                $this->deleteFile(base_path() . '/app/Http/Controllers/Api/' . $resource->payload->controllers->api);;
            }

            if (isset($resource->payload->routes->admin) && !is_null($resource->payload->routes->admin)) {
                $adminRoutesStorage = (array)json_decode(File::get(base_path() . '/routes/adminr/admin/routes.json'));
                if (isset($adminRoutesStorage[Str::lower($resource->name)])) {
                    unset($adminRoutesStorage[Str::lower($resource->name)]);
                }
                File::put(base_path() . '/routes/adminr/admin/routes.json', json_encode((object)$adminRoutesStorage));
            }


            if (isset($resource->payload->routes->api) && !is_null($resource->payload->routes->api)) {
                $apiRoutesStorage = (array)json_decode(File::get(base_path() . '/routes/adminr/api/routes.json'));
                if (isset($apiRoutesStorage[Str::lower($resource->name)])) {
                    unset($apiRoutesStorage[Str::lower($resource->name)]);
                }
                File::put(base_path() . '/routes/adminr/api/routes.json', json_encode((object)$apiRoutesStorage));
            }

            if (isset($resource->migration) && !is_null($resource->migration)) {
                if (\DB::table('migrations')->where('migration', $resource->migration)->first()) {
                    \DB::table('migrations')->where('migration', $resource->migration)->delete();
                }
            }
            $roles = Role::where('name', '!=', 'super_admin')->get();
            $permissions = Permission::where('resource', Str::lower($resource->name))->get();

            foreach ($roles as $role) {
                foreach ($permissions as $permission) {
                    if ($role->hasPermissionTo($permission)) {
                        $role->revokePermissionTo($permission);
                    }
                }
            }

            foreach ($permissions as $permission) {
                $permission->delete();
            }

            if (isset($resource->table) && !is_null($resource->table)) {
                Schema::dropIfExists($resource->table);
            }

            $menu = Menu::where('resource', $resource->id)->first();
            if (isset($menu) && !is_null($menu)) {
                $menu->delete();
            }

            $resource->delete();
        }

        return $this;
    }

}
