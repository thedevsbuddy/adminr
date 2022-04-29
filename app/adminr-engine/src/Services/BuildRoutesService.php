<?php

namespace Devsbuddy\AdminrEngine\Services;

use Devsbuddy\AdminrEngine\Database;
use Devsbuddy\AdminrEngine\Traits\CanManageFiles;
use Devsbuddy\AdminrEngine\Traits\HasStubs;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BuildRoutesService extends AdminrEngineService
{
    protected string $apiRouteTargetPath;
    protected string $apiRoutePath;
    protected string $adminRouteTargetPath;
    protected string $adminRoutePath;

    public function prepare(Request $request): BuildRoutesService|static
    {
        parent::prepare($request);
        $this->apiRouteTargetPath = base_path() . "/routes/adminr/api/" . $this->modelEntities . "/" . $this->modelEntities . ".json";
        $this->apiRoutePath = base_path() . '/routes/adminr/api/routes.json';
        $this->adminRouteTargetPath = base_path() . "/routes/adminr/admin/" . $this->modelEntities . "/" . $this->modelEntities . ".json";
        $this->adminRoutePath = base_path() . '/routes/adminr/admin/routes.json';
        return $this;
    }

    public function buildApiRoute(): static
    {
        try {
            if ($this->buildApi) {
                if ($this->hasSoftdeletes) {
                    $routeFile = $this->getRouteStub('api_entities_with_softdeletes');
                } else {
                    $routeFile = $this->getRouteStub('api_entities');
                }

                $stubPath = $this->hasSoftdeletes
                    ? $this->getRouteStub('api_entities_with_softdeletes', true)
                    : $this->getRouteStub('api_entities', true);

                $routeFile = $this->processStub($routeFile);

                $apiRoutesStorage = (array)json_decode(File::get($this->apiRoutePath));

                if (!isset($apiRoutesStorage[$this->modelEntities])) {
                    $apiRoutesStorage[$this->modelEntities] = $this->modelEntities . ".json";
                }

                $this->makeDirectory($this->apiRouteTargetPath);

                File::put($stubPath, $routeFile);
                File::copy($stubPath, $this->apiRouteTargetPath);
                File::put($this->apiRouteTargetPath, $routeFile);
                File::put($this->apiRoutePath, json_encode((object)$apiRoutesStorage));
            }
            return $this;
        } catch (\Exception | \Error $e) {
            throw $e;
        }
    }

    public function buildAdminRoute(): static
    {
        try {
            if ($this->hasSoftdeletes) {
                $routeFile = $this->getRouteStub('entities_with_softdeletes');
            } else {
                $routeFile = $this->getRouteStub('entities');
            }
            $stubPath = $this->hasSoftdeletes
                ? $this->getRouteStub('entities_with_softdeletes', true)
                : $this->getRouteStub('entities', true);

            $routeFile = $this->processStub($routeFile);

            $adminRoutesStorage = (array)json_decode(File::get($this->adminRoutePath));

            if (!isset($adminRoutesStorage[$this->modelEntities])) {
                $adminRoutesStorage[$this->modelEntities] = $this->modelEntities . ".json";
            }

            $this->makeDirectory($this->adminRouteTargetPath);
            File::put($stubPath, $routeFile);
            File::copy($stubPath, $this->adminRouteTargetPath);

            File::put($this->adminRouteTargetPath, $routeFile);
            File::put($this->adminRoutePath, json_encode((object)$adminRoutesStorage));

            return $this;
        } catch (\Exception | \Error $e) {
            throw $e;
        }
    }


    public function processStub($stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->modelName, $stub);
        $stub = str_replace('{{MODEL_ENTITIES}}', $this->modelEntities, $stub);
        $stub = str_replace('{{MODEL_ENTITY}}', $this->modelEntity, $stub);
        $stub = str_replace('{{API_CONTROLLER_NAMESPACE}}', $this->getApiControllerNamespaceStatement(), $stub);
        $stub = str_replace('{{CONTROLLER_NAMESPACE}}', $this->getControllerNamespaceStatement(), $stub);
        $stub = str_replace('{{CONTROLLER_CLASS}}', $this->controllerName, $stub);
        return str_replace('{{MIDDLEWARES}}', $this->getMiddlewaresStatement(), $stub);
    }


    protected function getApiControllerNamespaceStatement(): string
    {
        return "App\\Http\\Controllers\\Api\\";
    }

    protected function getMiddlewaresStatement(): string
    {
        return "[\"api\", \"auth:api\"]";
    }

    protected function getControllerNamespaceStatement(): string
    {
        return "\\App\\Http\\Controllers\\Admin";
    }


    public function rollback(): static
    {
        if (isset($this->modelEntities) && !is_null($this->modelEntities)) {
            $this->deleteDir(base_path() . '/routes/adminr/admin/' . $this->modelEntities);
            $this->deleteDir(base_path() . '/routes/adminr/api/' . $this->modelEntities);

            if (isset($this->adminRoutePath) && !is_null($this->adminRoutePath)) {
                $adminRoutesStorage = (array)json_decode(File::get($this->adminRoutePath));
                if (isset($adminRoutesStorage[$this->modelEntities])) {
                    unset($adminRoutesStorage[$this->modelEntities]);
                }
                File::put($this->adminRoutePath, json_encode((object)$adminRoutesStorage));
            }

            if (isset($this->apiRoutePath) && !is_null($this->apiRoutePath)) {
                $apiRoutesStorage = (array)json_decode(File::get($this->apiRoutePath));
                if (isset($apiRoutesStorage[$this->modelEntities])) {
                    unset($apiRoutesStorage[$this->modelEntities]);
                }
                File::put($this->apiRoutePath, json_encode((object)$apiRoutesStorage));
            }
        }
        return $this;
    }

}
