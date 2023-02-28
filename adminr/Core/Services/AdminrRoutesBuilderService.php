<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class AdminrRoutesBuilderService implements AdminrBuilderInterface
{
    use HasStubs;

    protected Fluent $resource;
    protected array $migrations;
    private AdminrBuilderService $builderService;

    public function __construct(AdminrBuilderService $service)
    {
        $this->builderService = $service;
        $this->migrations = $service->request->get('migrations');
        $this->resource = new Fluent([
            'name' => $this->builderService->resourceInfo->name,
            'files' => $this->builderService->resourceInfo->file->routes,
        ]);
    }

    public function prepare(): static
    {
        $this->prepareWebRoutes();
        $this->prepareApiRoutes();
        return $this;
    }

    private function prepareWebRoutes()
    {
        $stub = $this->builderService->hasSoftDelete
            ? $this->processStub($this->getRouteStub('entities'))
            : $this->processStub($this->getRouteStub('entities_with_softdeletes'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->web, $stub);
    }

    private function prepareApiRoutes()
    {
        $stub = $this->builderService->hasSoftDelete
        ? $this->processStub($this->getRouteStub('api_entities'))
        : $this->processStub($this->getRouteStub('api_entities_with_softdeletes'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->api, $stub);
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->builderService->modelName, $stub);
        $stub = str_replace('{{MODEL_ENTITIES}}', $this->builderService->modelEntities, $stub);
        $stub = str_replace('{{MODEL_ENTITY}}', $this->builderService->modelEntity, $stub);
        $stub = str_replace('{{RESOURCE_NAME}}', $this->builderService->resourceName, $stub);
        $stub = str_replace('{{API_CONTROLLER_NAMESPACE}}', "Adminr\\Resources\\".$this->builderService->resourceName."\\Http\\Controllers\\Api\\", $stub);
        $stub = str_replace('{{CONTROLLER_NAMESPACE}}', "Adminr\\Resources\\".$this->builderService->resourceName."\\Http\\Controllers\\", $stub);
        $stub = str_replace('{{CONTROLLER_CLASS}}', $this->builderService->controllerName, $stub);
        return str_replace('{{MIDDLEWARES}}', "", $stub);
    }

    public function build(): static
    {
        return $this;
    }

    public function rollback(): static
    {
        return $this;
    }

}
