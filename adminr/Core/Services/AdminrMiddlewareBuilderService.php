<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class AdminrMiddlewareBuilderService implements AdminrBuilderInterface
{
    use HasStubs;

    protected Fluent $resource;
    private AdminrBuilderService $builderService;

    public function __construct(AdminrBuilderService $service)
    {
        $this->builderService = $service;
        $this->resource = new Fluent([
            'name' => $this->builderService->resourceInfo->name,
            'files' => $this->builderService->resourceInfo->file->middlewares,
        ]);
    }

    public function prepare(): static
    {
        $this->prepareWebMiddleware();
        $this->prepareApiMiddleware();
        $this->prepareResourceMiddleware();
        return $this;
    }

    private function prepareWebMiddleware()
    {
        $stub = $this->processStub($this->getMiddlewareStub('web'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->web, $stub);
    }

    private function prepareApiMiddleware()
    {
        $stub = $this->processStub($this->getMiddlewareStub('api'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->api, $stub);
    }

    private function prepareResourceMiddleware()
    {
        $stub = $this->processStub($this->getMiddlewareStub('ResourceMiddleware'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->middleware, $stub);
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{MODEL_ENTITIES}}', $this->builderService->modelEntities, $stub);
        return str_replace('{{RESOURCE_NAME}}', $this->builderService->resourceName, $stub);
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
