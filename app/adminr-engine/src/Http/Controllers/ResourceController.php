<?php

namespace Devsbuddy\AdminrEngine\Http\Controllers;

use App\Http\Controllers\Controller;
use Devsbuddy\AdminrEngine\Models\AdminrResource;
use Devsbuddy\AdminrEngine\Services\ResourceService;
use Devsbuddy\AdminrEngine\Traits\HasStubs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;


class ResourceController extends Controller
{
    use HasStubs;

    public Request $request;
    public string $modelName;
    public string $controllerName;
    public string $modelPluralName;
    public string $modelEntities;
    public string $modelEntity;

    public function index(): View
    {
        $resources = AdminrResource::with('menu')->paginate(10);
        return view('adminr-engine::resources.index', compact('resources'));
    }

    public function store(Request $request): void
    {
        $this->request = $request;
        $this->modelName = Str::studly(Str::singular($this->request->get('model')));
        $this->modelPluralName = Str::plural($this->modelName);
        $this->controllerName = $this->modelName . 'Controller';
        $this->modelEntities = Str::snake($this->modelPluralName);
        $this->modelEntity = Str::snake($this->modelName);

        AdminrResource::create([
            'name' => $this->modelPluralName,
            'model' => $this->modelName,
            'controllers' => [
                'api' => $this->controllerName . '.php',
                'admin' => $this->controllerName . '.php'
            ],
            'menu' => [
                'label' => ucfirst($this->modelEntities),
                'url' => 'adminr.' . $this->modelEntities . 'index'
            ],
        ]);
    }

    public function configure($id): View|RedirectResponse
    {
        try {
            $id = decrypt($id);
            $resource = AdminrResource::findOrFail($id);
            $routes = json_decode(File::get(base_path() . '/routes/adminr/api/' . $resource->payload->routes->api));
            return view('adminr-engine::resources.configure', compact('resource', 'routes'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function getResource($id): JsonResponse
    {
        try {
            $resource = AdminrResource::where('id', $id)->first();
            return $this->success($resource, 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        } catch (\Error $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function updateApiMiddlewares($id, Request $request): JsonResponse
    {
        $resource = AdminrResource::where('id', $id)->first();
        if ($this->updateRouteFile($id, $request)) {
            return $this->successMessage("API public routes permission updated!", 200);
        } else {
            return $this->error("Something went wrong!", 500);
        }
    }

    private function updateRouteFile($id, Request $request): bool
    {
        $resource = AdminrResource::where('id', $id)->first();
        $routeFile = (array)json_decode(File::get(base_path() . '/routes/adminr/api/' . Str::lower($resource->name) . '/' . Str::lower($resource->name) . '.json'));

        foreach ($request->all() as $key => $method) {
            if ($method) {
                if (!in_array("auth:api", $routeFile[$key]->middleware)) {
                    array_push($routeFile[$key]->middleware, "auth:api");
                }
            } else {
                if (($apiKey = array_search("auth:api", $routeFile[$key]->middleware)) !== false) {
                    unset($routeFile[$key]->middleware[$apiKey]);
                }
            }
        }


        File::put(base_path() . '/routes/adminr/api/' . Str::lower($resource->name) . '/' . Str::lower($resource->name) . '.json', json_encode((object)$routeFile));

        return true;
    }


    public function destroy($id): RedirectResponse
    {
        $resource = AdminrResource::where('id', $id)->first();
        $resourceService = new ResourceService();
        $resourceService->rollback($resource->id);
        $resource->delete();
        return back()->with('success', 'Resource deleted successfully!');
    }


    public function getModelList(): JsonResponse
    {
        $models = File::allFiles(base_path() . '/app/Models');

        $modelList = [];

        foreach ($models as $model) {
            array_push($modelList, (object)[
                "file" => $model->getFilename(),
                "name" => collect(explode('.', $model->getFilename()))->first(),
            ]);
        }

        return response()->json($modelList, 200);
    }

    public function getModelColumns(): JsonResponse
    {
        $model = ("\\App\\Models\\" . request('model'));
        $model = new $model();
        $columns = \Schema::getColumnListing($model->getTable());

        $columnsBlackList = [
            "id",
            "avatar",
            "otp",
            "password",
            "email_verified_at",
            "remember_token",
            "created_at",
            "updated_at",
        ];

        $columns = collect($columns)->filter(function ($column) use ($columnsBlackList) {
            return !in_array($column, $columnsBlackList);
        })->toArray();

        return response()->json($columns);
    }

}

