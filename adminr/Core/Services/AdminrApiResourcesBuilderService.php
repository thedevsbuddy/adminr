<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class AdminrApiResourcesBuilderService implements AdminrBuilderInterface
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
            'files' => $this->builderService->resourceInfo->file->apiResources,
        ]);
    }

    public function prepare(): static
    {
        if($this->builderService->hasApiResource) {
            $stub = $this->processStub($this->getResourceStub('ApiResource'));
            File::put($this->resource->files->path->temp . '/' . $this->resource->files->files, $stub);
        }
        return $this;
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->builderService->modelName, $stub);
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
