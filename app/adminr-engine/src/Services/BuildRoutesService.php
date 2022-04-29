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
    protected $apiRouteTargetPath;
    protected $apiRoutePath;
    protected $adminRouteTargetPath;
    protected $adminRoutePath;

    /**
     * Prepares the service to generate resource
     *
     * @param Request $request
     * @return $this|AdminrEngineService
     */
    public function prepare(Request $request)
    {
        parent::prepare($request);
        $this->apiRouteTargetPath = base_path() . "/routes/adminr/api/" . $this->modelEntities . "/" . $this->modelEntities . ".json";
        $this->apiRoutePath = base_path() . '/routes/adminr/api/routes.json';
        $this->adminRouteTargetPath = base_path() . "/routes/adminr/admin/" . $this->modelEntities . "/" . $this->modelEntities . ".json";
        $this->adminRoutePath = base_path() . '/routes/adminr/admin/routes.json';
        return $this;
    }


    /**
     * Generates api routes
     *
     * @return $this
     * @throws \Exception
     */
    public function buildApiRoute()
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
        } catch (\Exception $e) {
            throw $e;
        } catch (\Error $e) {
            throw $e;
        }
    }

    /**
     * Generates admin routes
     *
     * @return $this
     * @throws \Exception
     */
    public function buildAdminRoute()
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
        } catch (\Exception $e) {
            throw $e;
        } catch (\Error $e) {
            throw $e;
        }
    }


    /**
     * Processes stubs
     *
     * @param $stub
     * @return mixed
     */
    public function processStub($stub)
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->modelName, $stub);
        $stub = str_replace('{{MODEL_ENTITIES}}', $this->modelEntities, $stub);
        $stub = str_replace('{{MODEL_ENTITY}}', $this->modelEntity, $stub);
        $stub = str_replace('{{API_CONTROLLER_NAMESPACE}}', $this->getApiControllerNamespaceStatement(), $stub);
        $stub = str_replace('{{CONTROLLER_NAMESPACE}}', $this->getControllerNamespaceStatement(), $stub);
        $stub = str_replace('{{CONTROLLER_CLASS}}', $this->controllerName, $stub);
        $stub = str_replace('{{MIDDLEWARES}}', $this->getMiddlewaresStatement(), $stub);
        return $stub;
    }


    protected function getApiControllerNamespaceStatement()
    {
        return "App\\Http\\Controllers\\Api\\";
    }

    /**
     * Returns middlewares for api routes
     *
     * @return string
     */
    protected function getMiddlewaresStatement()
    {
        return "[\"api\", \"auth:api\"]";
    }

    /**
     * Return admin controller namespace
     * @return string
     */
    protected function getControllerNamespaceStatement()
    {
        return "\\App\\Http\\Controllers\\Admin";
    }


    /**
     * Rollbacks generated files
     *
     * @return $this
     */
    public function rollback()
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
