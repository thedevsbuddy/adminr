<?php

namespace Adminr\System\Services;

use Adminr\System\Contracts\AdminrBuilderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;

class AdminrControllersBuilderService extends AdminrBuilderInterface
{
    protected string $apiControllerTargetPath;
    protected string $adminControllerTargetPath;
    protected Fluent $module;
    private AdminrBuilderService $builderService;

    public function inject(AdminrBuilderService $service): void
    {
        $this->builderService = $service;
        $this->module = $this->builderService->moduleInfo;
    }

    public function prepare(Request $request): static
    {
        $this->apiControllerTargetPath = base_path() . "/app/Http/Controllers/Api/$this->controllerName.php";
        $this->adminControllerTargetPath = base_path() . "/app/Http/Controllers/Admin/$this->controllerName.php";
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
