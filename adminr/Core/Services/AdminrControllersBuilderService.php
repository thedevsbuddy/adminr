<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;

class AdminrControllersBuilderService implements AdminrBuilderInterface
{
    use HasStubs;

    protected string $apiControllerTargetPath;
    protected string $adminControllerTargetPath;
    protected Fluent $resource;
    private AdminrBuilderService $builderService;

    /**
     * Injects [AdminrBuilderService] instance
     */
    public function inject(AdminrBuilderService $service): static
    {
        $this->builderService = $service;
        $this->resource = new Fluent([
            'name' => $this->builderService->resourceInfo->name,
            'files' => $this->builderService->resourceInfo->file->controllers,
        ]);
        return $this;
    }

    public function prepare(): static
    {
        $this->prepareAdminController();
        if ($this->builderService->buildApi) $this->prepareApiController();
        return $this;
    }

    private function prepareAdminController()
    {
        $stub = $this->builderService->hasSoftDelete
            ? $this->getControllerStub('ControllerWithSoftdeletes')
            : $this->getControllerStub('Controller');
        $stub = $this->processStub($stub);
        File::put($this->resource->files->path->temp->admin.'/'.$this->resource->files->files, $stub);
    }

    private function prepareApiController()
    {
        $stub = $this->builderService->hasSoftDelete
            ? $this->getControllerStub('ApiControllerWithSoftdeletes')
            : $this->getControllerStub('ApiController');
        $stub = $this->processStub($stub);
        File::put($this->resource->files->path->temp->api.'/'.$this->resource->files->files, $stub);
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->builderService->modelName, $stub);
        $stub = str_replace('{{CONTROLLER_CLASS}}', $this->builderService->controllerName, $stub);
        $stub = str_replace('{{MODEL_ENTITY}}', $this->builderService->modelEntity, $stub);
        $stub = str_replace('{{MODEL_ENTITIES}}', $this->builderService->modelEntities, $stub);
        return str_replace('{{RESULT_LIMIT}}', 10, $stub);
    }

    public function build(): static
    {
        // TODO: Implement build() method.
    }

    public function rollback(): static
    {
        // TODO: Implement rollback() method.
    }
}
