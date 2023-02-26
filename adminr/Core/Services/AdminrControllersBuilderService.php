<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class AdminrControllersBuilderService implements AdminrBuilderInterface
{
    use HasStubs;

    protected string $apiControllerTargetPath;
    protected string $adminControllerTargetPath;
    protected Fluent $resource;
    protected Array $migrations;
    private AdminrBuilderService $builderService;

    /**
     * Injects [AdminrBuilderService] instance
     */
    public function __construct(AdminrBuilderService $service)
    {
        $this->builderService = $service;
        $this->migrations = $service->request->get('migrations');
        $this->resource = new Fluent([
            'name' => $this->builderService->resourceInfo->name,
            'files' => $this->builderService->resourceInfo->file->controllers,
        ]);
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
        $controllerStub = $this->builderService->hasSoftDelete
            ? $this->getControllerStub('ApiControllerWithSoftdeletes')
            : $this->getControllerStub('ApiController');
        $controllerStub = $this->processStub($controllerStub);
        File::put($this->resource->files->path->temp->api.'/'.$this->resource->files->files, $controllerStub);
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->builderService->modelName, $stub);
        $stub = str_replace('{{CONTROLLER_CLASS}}', $this->builderService->controllerName, $stub);
        $stub = str_replace('{{MODEL_ENTITY}}', $this->builderService->modelEntity, $stub);
        $stub = str_replace('{{MODEL_ENTITIES}}', $this->builderService->modelEntities, $stub);
        $stub = str_replace('{{INDEX_QUERY}}', $this->getIndexQueryStatement(), $stub);
        $stub = str_replace('{{FOREIGN_ENTITY_DATA}}', $this->getForeignEntityDataStatement(), $stub);
        $stub = str_replace('{{FOREIGN_ENTITY_CREATE}}', $this->getForeignEntityCreateStatement(), $stub);
        $stub = str_replace('{{FOREIGN_ENTITY}}', $this->getForeignEntityStatement(), $stub);
        $stub = str_replace('{{FILE_UPLOAD_STATEMENT}}', $this->getFileUploadStatement(), $stub);
        $stub = str_replace('{{SAVE_DATA_STATEMENT}}', $this->getSaveDataStatement(), $stub);
        $stub = str_replace('{{FILE_UPDATE_STATEMENT}}', $this->getFileUpdateStatement(), $stub);
        $stub = str_replace('{{UPDATE_DATA_STATEMENT}}', $this->getUpdateDataStatement(), $stub);
        $stub = str_replace('{{DELETE_FILE_STATEMENT}}', $this->getDeleteFileStatement(), $stub);
        $stub = str_replace('{{FOREIGN_ENTITY_USE}}', $this->getForeignEntityUseStatement(), $stub);
        $stub = str_replace('{{RESOURCE_NAME}}', $this->builderService->resourceName, $stub);
        return $stub;
    }

    public function build(): static
    {
        return $this;
    }

    public function rollback(): static
    {
       return $this;
    }

    private function getIndexQueryStatement(): string
    {
        $indexQueryStmt = "\${$this->builderService->modelEntities} = {$this->builderService->modelName}::query()";
        foreach ($this->migrations as $migration) {
            if ($migration['field_name'] != 'id' || $migration['data_type'] != 'file') {
                if ($migration['can_search']) {
                        $indexQueryStmt .= "->when(!is_null(request()->get('_{$migration['field_name']}')), function(\$query){
                \$query->where('{$migration['field_name']}', 'LIKE', '%'.request()->get('_{$migration['field_name']}').'%');
            })";
                }
            }
        }
        if ($this->builderService->hasSoftDelete) {
            $indexQueryStmt .= "->when(request()->get('_with_trashed') == '1', function(\$query){
                \$query->withTrashed();
            })";
        }
        return $indexQueryStmt . "->paginate(10);";
    }

    private function getForeignEntityDataStatement(): string
    {
        $foreignEntityDataStmt = "";
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'foreignId') {
                if ($migration['related_model'] != 'auth') {
                    $foreignEntityDataStmt .= "$".Str::snake(Str::plural($migration['related_model'])). " = ". Str::ucfirst($migration['related_model']) . "::select('id', '" . $migration['related_model_label'] . "')->get();";
                }
            }
        }
        return $foreignEntityDataStmt;
    }

    private function getForeignEntityCreateStatement(): string
    {
        $hasForeignId = false;
        $hasAuthModel = false;
        $foreignEntityDataStmt = ", compact(";
        foreach ($this->migrations as $index => $migration) {
            if ($migration['data_type'] == 'foreignId') {
                if ($migration['related_model'] != 'auth') {
                    $foreignEntityDataStmt .= "'" . Str::snake(Str::plural($migration['related_model'])) . "'";
                    if($index < (count($this->migrations) - 1)){
                        $foreignEntityDataStmt .= ", ";
                    }
                    $hasAuthModel = true;
                }
                $hasForeignId = true;
            }
        }
        $foreignEntityDataStmt .= ")";
        return $hasForeignId && $hasAuthModel ? $foreignEntityDataStmt : "";
    }

    private function getForeignEntityStatement(): string
    {
        $foreignEntityDataStmt = '';
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'foreignId') {
                if ($migration['related_model'] != 'auth') {
                    $foreignEntityDataStmt .= ", '" . Str::snake(Str::plural($migration['related_model'])) . "'";
                }
            }
        }
        return $foreignEntityDataStmt;
    }

    private function getFileUploadStatement(): string
    {
        $fileUploadStmt = "";
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $fileUploadStmt .= "if(\$request->hasFile(\"" . Str::snake($migration['field_name']) . "\")){
                \$" . Str::snake($migration['field_name']) . " = \$this->uploadFile(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->builderService->modelEntities . "\")->getFilePath();";
                } else {
                    $fileUploadStmt .= "if(\$request->file(\"" . Str::snake($migration['field_name']) . "\")){
                \$" . Str::snake($migration['field_name']) . " = \$this->uploadFiles(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->builderService->modelEntities . "\")->getFilePaths();
                \$" . Str::snake($migration['field_name']) . " = json_encode(\$" . Str::snake($migration['field_name']) . ");";
                }
                $fileUploadStmt .= "\n\t\t\t} else {\n\t\t\t\t";
                if (!$migration['nullable']) {
                    $fileUploadStmt .= "return \$this->backError(\"Please select an image for " . Str::title(Str::replace('_', ' ', $migration['field_name'])) . "\");\n\t\t\t";
                } else {
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = null;\n\t\t\t";
                }
                $fileUploadStmt .= "}\n";
            }
        }
        return $fileUploadStmt;
    }

    private function getSaveDataStatement(): string
    {
        $saveDataStmt = "";
        $lastTabs = '';
        foreach ($this->migrations as $index => $migration) {
            if($index < (count($this->migrations) - 1)){
                $lastTabs = ", \n\t\t\t\t";
            }
            if ($migration['field_name'] == 'slug') {
                $saveDataStmt .= "\"" . Str::snake($migration['field_name']) . "\" => Str::slug(\$request->get(\"" . Str::snake($migration['slug_from']) . "\"))" . $lastTabs;
            } elseif ($migration['data_type'] == 'file') {
                $saveDataStmt .= "\"" . Str::snake($migration['field_name']) . "\" => \$" . Str::snake($migration['field_name']) . $lastTabs;
            } elseif ($migration['data_type'] == 'uuid') {
                $saveDataStmt .= "\"" . Str::snake($migration['field_name']) . "\" => Str::uuid()" . $lastTabs;
            } elseif ($migration['related_model'] == 'auth') {
                $saveDataStmt .= "\"" . Str::snake($migration['field_name']) . "\" => auth()->id()" . $lastTabs;
            } else {
                $saveDataStmt .= "\"" . Str::snake($migration['field_name']) . "\" => \$request->get(\"" . Str::snake($migration['field_name']) . "\")" . $lastTabs;
            }
        }

        return $saveDataStmt;
    }

    private function getFileUpdateStatement(): string
    {
        $fileUploadStmt = "";
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $fileUploadStmt .= "if(\$request->hasFile(\"" . Str::snake($migration['field_name']) . "\")){\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$this->uploadFile(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->builderService->modelEntities . "\")->getFilePath();\n\t\t\t\t";
                    $fileUploadStmt .= "\$this->deleteStorageFile($" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . ");\n\t\t\t";
                } else {
                    $fileUploadStmt .= "if(\$request->hasFile(\"" . Str::snake($migration['field_name']) . "\")){\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$this->uploadFiles(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->builderService->modelEntities . "\")->getFilePaths();\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = json_encode(\$" . Str::snake($migration['field_name']) . ");\n\t\t\t";
                    $fileUploadStmt .= "\$this->deleteStorageFiles(json_decode($" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . "));\n\t\t\t";
                }
                $fileUploadStmt .= "}";
                $fileUploadStmt .= " else {\n\t\t\t\t";
                if (!$migration['nullable']) {
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . ";\n\t\t\t";
                } else {
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = null;\n\t\t\t";
                }
                $fileUploadStmt .= "}\n";
            }
        }

        return $fileUploadStmt;
    }

    private function getUpdateDataStatement(): string
    {
        $updateDataStmt = "";
        foreach ($this->migrations as $index => $migration) {
            $lastTabs = ",\n\t\t\t\t";
            if ($migration['field_name'] != 'id') {
                if ($migration['field_name'] == 'slug') {
                    $updateDataStmt .= "\"" . Str::snake($migration['field_name']) . "\" => Str::slug(\$request->get(\"" . $migration['slug_from'] . "\"))" . $lastTabs;
                } elseif ($migration['data_type'] == 'file') {
                    $updateDataStmt .= "\"" . Str::snake($migration['field_name']) . "\" => \$" . Str::snake($migration['field_name']) . $lastTabs;
                } elseif ($migration['data_type'] == 'uuid') {
                    $updateDataStmt .= "";
                } elseif ($migration['related_model'] == 'auth') {
                    $updateDataStmt .= "\"" . Str::snake($migration['field_name']) . "\" => auth()->id()" . $lastTabs;
                } else {
                    $updateDataStmt .= "\"" . Str::snake($migration['field_name']) . "\" => \$request->get(\"" . Str::snake($migration['field_name']) . "\")" . $lastTabs;
                }
            }
        }
        return $updateDataStmt;
    }

    private function getDeleteFileStatement(): string
    {
        $deleteFileStmt = "";
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $deleteFileStmt .= "\$this->deleteStorageFile($" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . ");\n\t\t\t";
                } else {
                    $deleteFileStmt .= "\$this->deleteStorageFiles(json_decode($" . $this->builderService->modelEntity . "->" . Str::snake($migration['field_name']) . "));\n\t\t\t";
                }
            }
        }
        return $deleteFileStmt;
    }

    private function getForeignEntityUseStatement(): string
    {
        $foreignEntityUseStmt = '';
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'foreignId') {
                if ($migration['related_model'] != 'auth') {
                    if ($migration['related_model'] == 'User') {
                        $foreignEntityUseStmt .= "use App\\Models\\" . Str::ucfirst($migration['related_model']) . ";\n";
                    } else {
                        $foreignEntityUseStmt .= "use Adminr\\Resources\\".$this->builderService->resourceName."\\Models\\" . Str::ucfirst($migration['related_model']) . ";\n";
                    }
                }
            }
        }
        return $foreignEntityUseStmt;
    }
}
