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

    public $request;
    public $modelName;
    public $modelPluralName;
    public $modelEntity;
    public $modelEntities;
    public $controllerName;
    public $migrationFileName;
    public $tableName;
    public $currentOperationId;
    public $operationDirectory;

    public $hasSoftdeletes;
    public $buildApi;

    /**
     * Prepare the service for resource generation
     *
     * @param Request $request
     * @return $this
     */
    public function prepare(Request $request)
    {
        $this->request = $request;
        $this->currentOperationId = Str::random(12);
        $this->operationDirectory = 'adminr-core/' . date('Y_m_d_his') . '_' . $this->currentOperationId;
        $this->stubsDirectory = storage_path($this->operationDirectory . '/stubs');
        $this->initialize();
        return $this;
    }


    /**
     * Initialize the service
     *
     */
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

    /**
     * Create a directory on provided path
     *
     * @param $path
     * @param bool $commit
     */
    protected function makeDirectory($path, $commit = false)
    {
        $permission = $commit ? 0775 : 0775;
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), $permission, true, true);
        }
    }


    /**
     * Clean the working directory
     *
     */
    public function cleanUp()
    {
        if (File::isDirectory(dirname(storage_path($this->operationDirectory . '/stubs')))) {
            File::deleteDirectory(dirname(storage_path($this->operationDirectory . '/stubs')));
        }
    }

}
