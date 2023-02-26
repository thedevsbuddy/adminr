<?php

namespace Adminr\Core\Services;

use Adminr\Core\Traits\{HasStubs};
use Illuminate\Http\Request;
use Illuminate\Support\{Facades\File, Fluent, Str};

class AdminrBuilderService
{
    use HasStubs;

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
    public string $currentSessionId;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->modelName = Str::studly(Str::singular($this->request->get('model')));
        $this->currentSessionId = Str::random();
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
    }

    public function publish(): void
    {
        File::copyDirectory(storage_path(".temp/$this->currentSessionId/$this->resourceName"), resourcesPath($this->resourceName));
        File::deleteDirectory(storage_path(".temp/$this->currentSessionId"));
    }

    public function cleanUp(): void
    {
        if (File::isDirectory(storage_path(".temp/" . $this->resourceName))) {
            File::deleteDirectory(storage_path(".temp/" . $this->resourceName));
        }
    }

    private function createStubsDirectories(): void
    {
        File::deleteDirectory(storage_path(".temp"));
        File::makeDirectory(storage_path(".temp"), 0775, true, true);
        foreach ($this->resourceInfo->file->toArray() as $tempPath) {
            if (gettype($tempPath->path->temp) == 'object') {
                foreach ($tempPath->path->temp->toArray() as $path) {
                    File::makeDirectory($path, 0775, true, true);
                }
            } else {
                File::makeDirectory($tempPath->path->temp, 0775, true, true);
            }
        }
    }

    private function prepareResourceInfo(): void
    {
        $this->resourceInfo = new Fluent([
            'name' => $this->resourceName,
            'file' => new Fluent([
                'migration' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->currentSessionId/$this->resourceName/database")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/database")),
                    ]),
                    'files' => new Fluent([
                        'migration' => Str::snake("create_" . $this->modelEntities . "_table") . ".php",
                        'schema' => 'schema.json'
                    ]),
                ]),
                'apiResources' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->currentSessionId/$this->resourceName/Http/ApiResources")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/Http/ApiResources")),
                    ]),
                    'files' => $this->modelName . "Resource.php",
                ]),
                'controllers' => new Fluent([
                    'path' => new Fluent([
                        'temp' => new Fluent([
                            'admin' => sanitizePath(storage_path(".temp/$this->currentSessionId/$this->resourceName/Http/Controllers")),
                            'api' => sanitizePath(storage_path(".temp/$this->currentSessionId/$this->resourceName/Http/Controllers/Api")),
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
                        'temp' => sanitizePath(storage_path(".temp/$this->currentSessionId/$this->resourceName/Http/Requests")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/Http/Requests")),
                    ]),
                    'files' => new  Fluent([
                        'create' => "Create" . $this->modelName . "Request.php",
                        'update' => "Update" . $this->modelName . "Request.php"
                    ]),
                ]),
                'model' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->currentSessionId/$this->resourceName/Models")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/Models")),
                    ]),
                    'files' => $this->modelName . ".php",
                ]),
                'routes' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->currentSessionId/$this->resourceName/Routes")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName/Routes")),
                    ]),
                    'files' => new Fluent([
                        'web' => "web.php",
                        'api' => "api.php"
                    ]),
                ]),
                'views' => new Fluent([
                    'path' => new Fluent([
                        'temp' => sanitizePath(storage_path(".temp/$this->currentSessionId/$this->resourceName/Views")),
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
                        'temp' => sanitizePath(storage_path(".temp/$this->currentSessionId/$this->resourceName")),
                        'main' => sanitizePath(resourcesPath("$this->resourceName")),
                    ]),
                    'files' => "resource.json",
                ]),
            ])
        ]);
    }
}
