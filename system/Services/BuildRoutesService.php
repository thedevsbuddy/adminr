<?php

namespace Devsbuddy\AdminrEngine\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BuildRoutesService extends AdminrEngineService
{
    protected string $apiRoutePath;
    protected string $adminRoutePath;
    protected string $adminRouteProcessedStub;
    protected string $apiRouteProcessedStub;

    public function prepare(Request $request): static
    {
        parent::prepare($request);
        $this->apiRoutePath = base_path() . '/routes/adminr/api.php';
        $this->adminRoutePath = base_path() . '/routes/adminr/admin.php';
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

                $routeFile = $this->processStub($routeFile);
                $this->apiRouteProcessedStub = $routeFile;
                $apiRoutesStorage = File::get($this->apiRoutePath);

                $apiRoutesStorage = $apiRoutesStorage . "\n" . $routeFile;
                File::put($this->apiRoutePath, $apiRoutesStorage);
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

            $routeFile = $this->processStub($routeFile);
            $this->adminRouteProcessedStub = $routeFile;
            $adminRoutesStorage = File::get($this->adminRoutePath);

            $adminRoutesStorage = $adminRoutesStorage . "\n" . $routeFile;
            File::put($this->adminRoutePath, $adminRoutesStorage);
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
        return "";
    }

    protected function getControllerNamespaceStatement(): string
    {
        return "\\App\\Http\\Controllers\\Admin\\";
    }

    public function rollback(): static
    {
        if (isset($this->modelEntities) && !is_null($this->modelEntities)) {
            if (isset($this->adminRoutePath) && !is_null($this->adminRoutePath)) {
                $adminRoutesStorage = File::get($this->adminRoutePath);
                $previousFile = Str::replace(search: $this->adminRouteProcessedStub, replace: "", subject: $adminRoutesStorage);
                File::put($this->adminRoutePath, $previousFile);
            }

            if (isset($this->apiRoutePath) && !is_null($this->apiRoutePath)) {
                $apiRoutesStorage = File::get($this->apiRoutePath);
                $previousFile = Str::replace(search: $this->adminRouteProcessedStub, replace: "", subject: $apiRoutesStorage);
                File::put($this->apiRoutePath, $previousFile);
            }
        }
        return $this;
    }

}
