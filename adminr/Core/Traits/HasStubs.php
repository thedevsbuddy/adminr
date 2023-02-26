<?php

namespace Adminr\Core\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HasStubs
{
    public string $stubsDirectory = __DIR__ . '/../Stubs';

    public function getControllerStub($filePath): ?string
    {
        return File::get($this->stubsDirectory . '/controllers/' . $filePath . '.stub');
    }

    public function getModelStub($model): ?string
    {
        return File::get($this->stubsDirectory . '/models/' . $model . '.stub');
    }

    public function getMigrationStub($migration): ?string
    {
        return File::get($this->stubsDirectory . '/database/migrations/' . $migration . '.stub');
    }

    public function getViewStub($view): ?string
    {
        return File::get($this->stubsDirectory . '/views/' . $view . '.stub');
    }

    public function getRouteStub($route): ?string
    {
        return File::get($this->stubsDirectory . '/routes/' . $route . '.stub');
    }

    public function getResourceStub($resourceFile): ?string
    {
        return File::get($this->stubsDirectory . '/resources/' . $resourceFile . '.stub');
    }

    public function getRequestStub($requestFile): ?string
    {
        return File::get($this->stubsDirectory . '/requests/' . $requestFile . '.stub');
    }
}
