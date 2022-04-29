<?php
namespace Devsbuddy\AdminrEngine\Services;

use Devsbuddy\AdminrEngine\Traits\CanManageFiles;
use Devsbuddy\AdminrEngine\Traits\HasStubs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminrEngineService
{
    use HasStubs, CanManageFiles;

    public Request $request;
    public string $modelName;
    public string $modelPluralName;
    public string $modelEntity;
    public string $modelEntities;
    public string $controllerName;
    public string $migrationFileName;
    public string $tableName;
    public string $currentOperationId;
    public string $operationDirectory;

    public bool $hasSoftdeletes;
    public bool $buildApi;

    public function prepare(Request $request): static
    {
        $this->request = $request;
        $this->currentOperationId = Str::random(12);
        $this->operationDirectory = 'adminr-engine/' . date('Y_m_d_his') . '_' . $this->currentOperationId;
        $this->stubsDirectory = storage_path($this->operationDirectory . '/stubs');
        $this->initialize();
        return $this;
    }


    public function initialize()
    {
        $this->modelName = Str::studly(Str::singular($this->request->get('model')));
        $this->modelPluralName = Str::plural($this->modelName);
        $this->modelEntity = Str::snake($this->modelName);
        $this->modelEntities = Str::snake(Str::plural($this->modelName));
        $this->controllerName = $this->modelName . 'Controller';
        $this->tableName = Str::snake(Str::plural($this->modelName));
        $this->migrationFileName = date('Y_m_d_his') . '_create_' . $this->tableName . '_table';
        $this->hasSoftdeletes = $this->request->get('softdeletes');
        $this->buildApi = $this->request->get('build_api');

        $this->makeDirectory(storage_path($this->operationDirectory . '/stubs'));
        File::copyDirectory(__DIR__ . '/../../resources/stubs/', storage_path($this->operationDirectory . '/stubs'));
    }

    protected function makeDirectory($path, $commit = false)
    {
        $permission = $commit ? 0775 : 0775;
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), $permission, true, true);
        }
    }

    public function cleanUp()
    {
        if (File::isDirectory(dirname(storage_path($this->operationDirectory . '/stubs')))) {
            File::deleteDirectory(dirname(storage_path($this->operationDirectory . '/stubs')));
        }
    }

}
