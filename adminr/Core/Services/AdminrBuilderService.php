<?php

namespace Adminr\Core\Services;

use Adminr\Core\Traits\{CanManageFiles,HasStubs};
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
    public string $currentOperationId;
    public string $operationDirectory;
    public bool $hasSoftDelete;
    public bool $buildApi;

    public function initialize(Request $request): void
    {
        $this->request = $request;
        $this->currentOperationId = Str::random(12);
        $this->operationDirectory = 'adminr-engine/' . date('Y_m_d_his') . '_' . $this->currentOperationId;
        $this->stubsDirectory = storage_path($this->operationDirectory . '/stubs');

        $this->modelName = Str::studly(Str::singular($this->request->get('model')));
        $this->modelPluralName = Str::plural($this->modelName);
        $this->modelEntity = Str::snake($this->modelName);
        $this->modelEntities = Str::snake(Str::plural($this->modelName));
        $this->controllerName = $this->modelName . 'Controller';
        $this->tableName = Str::snake(Str::plural($this->modelName));
        $this->migrationFileName = date('Y_m_d_his') . '_create_' . $this->tableName . '_table';
        $this->hasSoftDelete = $this->request->get('softdeletes');
        $this->buildApi = $this->request->get('build_api');

        /// Prepares module info
        $this->prepareModule();
        $this->makeDirectory(storage_path($this->operationDirectory . '/stubs'));
        File::copyDirectory(__DIR__ . '/../../resources/stubs/', storage_path($this->operationDirectory . '/stubs'));
    }

    protected function makeDirectory($path): void
    {
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0775, true, true);
        }
    }

    protected function createStubsDirectories(): void
    {
        foreach ($this->resourceInfo->get('filePaths') as $tempPath){
            if(!is_array($tempPath) || !is_object($tempPath)){
                $dir = collect(explode('/', $tempPath));
                $dir->pop();
                $dir = $dir->join('/');
                File::makeDirectory(dirname($dir), 0775, true, true);
            } else {
                foreach ($tempPath as $path){
                    $dir = collect(explode('/', $path));
                    $dir->pop();
                    $dir = $dir->join('/');
                    File::makeDirectory(dirname($dir), 0775, true, true);
                }
            }
        }
    }

    public function cleanUp(): void
    {
        if (File::isDirectory(dirname(storage_path($this->operationDirectory . '/stubs')))) {
            File::deleteDirectory(dirname(storage_path($this->operationDirectory . '/stubs')));
        }
    }

    private function prepareModule(): void
    {
        $this->resourceInfo = new Fluent([
            'name' => $this->resourceName,
            'filePaths' => [
                'migrationFilePath' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                'schemaFilePath' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                'apiControllerFilePath' => resourcesPath("/$this->resourceName/Http/Controllers/Api/$this->controllerName.php"),
                'controllerFilePath' => resourcesPath("/$this->resourceName/Http/Controllers/$this->controllerName.php"),
                'createRequestFilePath' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                'updateRequestFilePath' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                'modelFilePath' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                'routesFilePath' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                'apiRoutesFilePath' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                'viewsFilePath' => [
                    'index' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                    'create' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                    'edit' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
                ],
                'moduleFilePath' => resourcesPath("/$this->resourceName/Models/$this->modelEntity.php"),
            ]
        ]);
    }
}


//$stub = \Illuminate\Support\Facades\File::get(stubsPath('models/Model'));
//$stub = \Illuminate\Support\Str::replace('{{MODEL_CLASS}}', 'TestModel', $stub);
//$tempModel = storage_path('.temp/Model.stub');
//\Illuminate\Support\Facades\File::put($tempModel, $stub);
//\Illuminate\Support\Facades\File::copy($tempModel, app_path('Models/TestModel.php'));
//\Illuminate\Support\Facades\File::delete($tempModel);
//dump($stub);
