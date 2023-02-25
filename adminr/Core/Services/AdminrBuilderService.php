<?php

namespace Adminr\Core\Services;

use Adminr\Core\Traits\{CanManageFiles, HasStubs};
use Illuminate\Http\Request;
use Illuminate\Support\{Facades\File, Fluent, Str};

class AdminrBuilderService
{
    use HasStubs, CanManageFiles;

    public Fluent $resourceInfo;

    public Request $request;
    public string $resourceName;
    public string $modelName;
    public string $modelPluralName;
    public string $modelEntity;
    public string $modelEntities;
    public string $controllerName;
    public string $migrationFileName;
    public string $tableName;
    public bool $hasSoftDelete;
    public bool $buildApi;

    public function init(Request $request): void
    {
        $this->request = $request;

        $this->modelName = Str::studly(Str::singular($this->request->get('model')));
        $this->resourceName = $this->modelName;
        $this->modelPluralName = Str::plural($this->modelName);
        $this->modelEntity = Str::snake($this->modelName);
        $this->modelEntities = Str::snake(Str::plural($this->modelName));
        $this->controllerName = $this->modelName . 'Controller';
        $this->tableName = Str::snake(Str::plural($this->modelName));
        $this->migrationFileName = date('Y_m_d_his') . '_create_' . $this->tableName . '_table';
        $this->hasSoftDelete = $this->request->get('softdeletes');
        $this->buildApi = $this->request->get('build_api');

        /// Prepares module info
        $this->prepareResourceInfo();

        $this->createStubsDirectories();

//        File::copyDirectory(__DIR__ . '/../../resources/stubs/', storage_path($this->operationDirectory . '/stubs'));
    }

    protected function makeDirectory($path): void
    {
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0775, true, true);
        }
    }


    public function cleanUp(): void
    {
        if (File::isDirectory(storage_path(".temp/" . $this->resourceName))) {
            File::deleteDirectory(storage_path(".temp/" . $this->resourceName));
        }
    }

    private function createStubsDirectories(): void
    {
        foreach ($this->resourceInfo->get('files') as $tempPath) {
            if (typeOf($tempPath->path->main) == Fluent::class) {
                foreach ($tempPath->path->main as $path) {
                    File::makeDirectory($path, 0775, true, true);
                }
            } else {
                File::makeDirectory($tempPath->path->main, 0775, true, true);
            }
        }
        if (!File::isDirectory(storage_path(".temp"))) File::makeDirectory(storage_path(".temp"), 0775, true, true);
        File::copyDirectory(resourcesPath($this->resourceName), storage_path(".temp/" . $this->resourceName));
    }

    private function prepareResourceInfo(): void
    {
        $this->resourceInfo = new Fluent([
            'name' => $this->resourceName,
            'files' => new Fluent([
                'migration' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->resourceName/database")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/database")),
                    ]),
                    'files' => new Fluent([
                        'migration' => Str::snake(now()->format('Y_m_d_his') . "_create_" . $this->modelEntities . "table") . ".php",
                        'schema' => 'schema.json'
                    ]),
                ]),
                'controllers' => new Fluent([
                    'path' => new Fluent([
                        'temp' => new Fluent([
                            'admin' => sanitizePath(storage_path(".temp/$this->resourceName/Http/Controllers")),
                            'api' => sanitizePath(storage_path(".temp/$this->resourceName/Http/Controllers/Api")),
                        ]),
                        'main' => new Fluent([
                            'admin' => sanitizePath(resourcesPath("$this->resourceName/Http/Controllers")),
                            'api' => sanitizePath(resourcesPath("$this->resourceName/Http/Controllers/Api"))
                        ]),
                    ]),
                    'files' => $this->controllerName . ".php",
                ]),
                'requests' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->resourceName/Http/Requests")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/Http/Requests")),
                    ]),
                    'files' => new  Fluent([
                        'create' => "Create" . $this->modelName . "Request.php",
                        'update' => "Update" . $this->modelName . "Request.php"
                    ]),
                ]),
                'model' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->resourceName/Models")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/Models")),
                    ]),
                    'files' => $this->modelName . ".php",
                ]),
                'routes' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->resourceName/Routes")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/Routes")),
                    ]),
                    'files' => new Fluent([
                        'web' => "web.php",
                        'api' => "api.php"
                    ]),
                ]),
                'views' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->resourceName/Views")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/Views")),
                    ]),
                    'files' => new Fluent([
                        'index' => "index.blade.php",
                        'create' => "create.blade.php",
                        'edit' => "edit.blade.php"
                    ]),
                ]),
                'resource' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->resourceName")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName")),
                    ]),
                    'files' => "resource.json",
                ]),
            ])
        ]);
    }
}
