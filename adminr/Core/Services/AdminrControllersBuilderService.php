<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;

class AdminrControllersBuilderService implements AdminrBuilderInterface
{
    protected string $apiControllerTargetPath;
    protected string $adminControllerTargetPath;
    protected Fluent $module;
    private AdminrBuilderService $builderService;

    /**
     * Injects [AdminrBuilderService] instance
     */
    public function inject(AdminrBuilderService $service): void
    {
        $this->builderService = $service;
        $this->module = $this->builderService->moduleInfo;
    }

    public function prepare(Request $request): static
    {
        $this->apiControllerTargetPath = base_path() . "/app/Http/Controllers/Api/$this->builderService->controllerName.php";
        $this->adminControllerTargetPath = base_path() . "/app/Http/Controllers/Admin/$this->builderService->controllerName.php";
        return $this;
    }

    public function processStub(string $stub): array|string
    {
        /// TODO: Check where to use this service instance
        $this->builderService->moduleInfo->get('asd');
//       $this->module->
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
