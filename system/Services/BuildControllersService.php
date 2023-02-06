<?php

namespace Devsbuddy\AdminrEngine\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BuildControllersService extends AdminrEngineService
{
    protected string $apiControllerTargetPath;
    protected string $adminControllerTargetPath;

    public function prepare(Request $request): static
    {
        parent::prepare($request);
        $this->apiControllerTargetPath = base_path() . "/app/Http/Controllers/Api/$this->controllerName.php";
        $this->adminControllerTargetPath = base_path() . "/app/Http/Controllers/Admin/$this->controllerName.php";
        return $this;
    }

    public function buildApiController(): static
    {
        try {
            if ($this->buildApi) {

                $controllerStub = $this->hasSoftdeletes
                    ? $this->getControllerStub('ApiControllerWithSoftdeletes')
                    : $this->getControllerStub('ApiController');

                $stubPath = $this->hasSoftdeletes
                    ? $this->getControllerStub('ApiControllerWithSoftdeletes', true)
                    : $this->getControllerStub('ApiController', true);

                $controllerStub = $this->processStub($controllerStub);

                $this->makeDirectory($this->apiControllerTargetPath);
                File::put($stubPath, $controllerStub);
                File::copy($stubPath, $this->apiControllerTargetPath);
            }
            return $this;
        } catch (\Exception | \Error $e) {
            throw $e;
        }
    }

    public function buildController(): static
    {
        try {
            $controllerStub = $this->hasSoftdeletes
                ? $this->getControllerStub('ControllerWithSoftdeletes')
                : $this->getControllerStub('Controller');

            $stubPath = $this->hasSoftdeletes
                ? $this->getControllerStub('ControllerWithSoftdeletes', true)
                : $this->getControllerStub('Controller', true);

            $controllerStub = $this->processStub($controllerStub);

            $this->makeDirectory($this->adminControllerTargetPath);
            File::put($stubPath, $controllerStub);
            File::copy($stubPath, $this->adminControllerTargetPath);

            return $this;
        } catch (\Exception | \Error $e) {
            throw $e;
        }
    }

    public function processStub($stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->modelName, $stub);
        $stub = str_replace('{{CONTROLLER_CLASS}}', $this->controllerName, $stub);
        $stub = str_replace('{{MODEL_ENTITY}}', $this->modelEntity, $stub);
        $stub = str_replace('{{MODEL_ENTITIES}}', $this->modelEntities, $stub);
        $stub = str_replace('{{RESULT_LIMIT}}', config('adminr-engine.api.result_limit') ?: 10, $stub);
        $stub = str_replace('{{SEARCH_STATEMENTS}}', $this->getSearchStatement(), $stub);
        $stub = str_replace('{{VALIDATION_STATEMENT}}', $this->getValidationStatement(), $stub);
        $stub = str_replace('{{UPDATE_VALIDATION_STATEMENT}}', $this->getUpdateValidationStatement(), $stub);
        $stub = str_replace('{{FILE_UPLOAD_STATEMENT}}', $this->getFileUploadStatement(), $stub);
        $stub = str_replace('{{FILE_UPLOAD_API_STATEMENT}}', $this->getFileUploadApiStatement(), $stub);
        $stub = str_replace('{{FILE_UPDATE_STATEMENT}}', $this->getFileUpdateStatement(), $stub);
        $stub = str_replace('{{SAVE_DATA_STATEMENT}}', $this->getSaveDataStatement(), $stub);
        $stub = str_replace('{{UPDATE_DATA_STATEMENT}}', $this->getUpdateDataStatement(), $stub);
        $stub = str_replace('{{DELETE_FILE_STATEMENT}}', $this->getDeleteFileStatement(), $stub);
        $stub = str_replace('{{FOREIGN_ENTITY_USE}}', $this->getForeignEntityUseStatement(), $stub);
        $stub = str_replace('{{FOREIGN_ENTITY_DATA}}', $this->getForeignEntityDataStatement(), $stub);
        $stub = str_replace('{{FOREIGN_ENTITY}}', $this->getForeignEntityStatement(), $stub);
        $stub = str_replace('{{FOREIGN_ENTITY_CREATE}}', $this->getForeignEntityCreateStatement(), $stub);
        return str_replace('{{TRASHED_FILTER}}', $this->getTrashedFilterStatement(), $stub);
    }

    protected function getSearchStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $searchStmt = '';
        foreach ($migrations as $migration) {
            if ($migration['field_name'] != 'id' || $migration['data_type'] != 'file') {
                if ($migration['can_search'] == true) {
                    $searchStmt .= "if(\$request->has('" . Str::snake($migration['field_name']) . "') && !is_null(\$request->get('" . Str::snake($migration['field_name']) . "'))){\n\t\t\t\t";
                    $searchStmt .= "$" . $this->modelEntities . "->where('" . Str::snake($migration['field_name']) . "', 'LIKE', '%'.\$request->get('" . Str::snake($migration['field_name']) . "').'%');\n\t\t\t";
                    $searchStmt .= "}\n\t\t\t";
                }
            }
        }

        return $searchStmt;
    }

    protected function getTrashedFilterStatement(): string
    {
        $trashedFilterStmt = "";
        if ($this->hasSoftdeletes) {
            $trashedFilterStmt .= "if(\$request->has('trashed') && !is_null(\$request->get('trashed'))){
                \$$this->modelEntities->onlyTrashed();
            }
        ";
        }
        return $trashedFilterStmt;
    }

    protected function getValidationStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $validationStmt = "\$request->validate([\n\t\t\t\t";
        foreach ($migrations as $migration) {
            $lastTabs = ",\n\t\t\t\t";
            if ($migration['data_type'] != 'slug') {
                if ($migration['related_model'] != 'auth') {
                    if ($migration['data_type'] != 'uuid') {
                        if ($migration == $migrations[count($migrations) - 1]) {
                            $lastTabs = ",\n\t\t\t";
                        }
                        $isUnique = "";
                        if ($migration['unique']) {
                            $isUnique = ", \"unique:" . $this->tableName . "\"";
                        }
                        if ($migration['nullable'] == false) {
                            $validationStmt .= "\"" . Str::snake($migration['field_name']) . "\" => [\"required\"" . $isUnique . "]" . $lastTabs;
                        }
                    }
                }
            }
        }
        $validationStmt .= "]);";
        return $validationStmt;
    }

    protected function getUpdateValidationStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $validationStmt = "\$request->validate([\n\t\t\t\t";
        foreach ($migrations as $migration) {
            $lastTabs = ",\n\t\t\t\t";
            if ($migration['data_type'] != 'slug') {
                if ($migration['related_model'] != 'auth') {
                    if ($migration['data_type'] != 'uuid') {
                        if ($migration['data_type'] != 'file') {
                            if ($migration == $migrations[count($migrations) - 1]) {
                                $lastTabs = "\n\t\t\t";
                            }
                            if ($migration['nullable'] == false) {
                                $validationStmt .= "\"" . Str::snake($migration['field_name']) . "\" => [\"required\"]" . $lastTabs . "";
                            }
                        }
                    }
                }
            }
        }
        $validationStmt .= "]);";
        return $validationStmt;
    }

    protected function getFileUploadStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $fileUploadStmt = "";
        foreach ($migrations as $migration) {

            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $fileUploadStmt .= "if(\$request->hasFile(\"" . Str::snake($migration['field_name']) . "\")){\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$this->uploadFile(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->modelEntities . "\")->getFilePath();\n\t\t\t";
                } else {
                    $fileUploadStmt .= "if(\$request->file(\"" . Str::snake($migration['field_name']) . "\")){\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$this->uploadFiles(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->modelEntities . "\")->getFilePaths();\n\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = json_encode(\$" . Str::snake($migration['field_name']) . ");\n\t\t\t";
                }
                $fileUploadStmt .= "}";
                $fileUploadStmt .= " else {\n\t\t\t\t";
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

    protected function getFileUploadApiStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $fileUploadStmt = "";
        foreach ($migrations as $migration) {

            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $fileUploadStmt .= "if(\$request->hasFile(\"" . Str::snake($migration['field_name']) . "\")){\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$this->uploadFile(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->modelEntities . "\")->getFilePath();\n\t\t\t";
                } else {
                    $fileUploadStmt .= "if(\$request->file(\"" . Str::snake($migration['field_name']) . "\")){\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$this->uploadFiles(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->modelEntities . "\")->getFilePaths();\n\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = json_encode(\$" . Str::snake($migration['field_name']) . ");\n\t\t\t";
                }
                $fileUploadStmt .= "}";
                $fileUploadStmt .= " else {\n\t\t\t\t";
                if (!$migration['nullable']) {
                    $fileUploadStmt .= "return \$this->error(\"Please select an image for " . Str::title(Str::replace('_', ' ', $migration['field_name'])) . "\");\n\t\t\t";
                } else {
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = null;\n\t\t\t";
                }
                $fileUploadStmt .= "}\n";
            }
        }

        return $fileUploadStmt;
    }

    protected function getFileUpdateStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $fileUploadStmt = "";
        foreach ($migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $fileUploadStmt .= "if(\$request->hasFile(\"" . Str::snake($migration['field_name']) . "\")){\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$this->uploadFile(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->modelEntities . "\")->getFilePath();\n\t\t\t\t";
                    $fileUploadStmt .= "\$this->deleteStorageFile($" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . ");\n\t\t\t";
                } else {
                    $fileUploadStmt .= "if(\$request->hasFile(\"" . Str::snake($migration['field_name']) . "\")){\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$this->uploadFiles(\$request->file(\"" . Str::snake($migration['field_name']) . "\"), \"" . $this->modelEntities . "\")->getFilePaths();\n\t\t\t\t";
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = json_encode(\$" . Str::snake($migration['field_name']) . ");\n\t\t\t";
                    $fileUploadStmt .= "\$this->deleteStorageFiles(json_decode($" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . "));\n\t\t\t";
                }
                $fileUploadStmt .= "}";
                $fileUploadStmt .= " else {\n\t\t\t\t";
                if (!$migration['nullable']) {
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = \$" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . ";\n\t\t\t";
                } else {
                    $fileUploadStmt .= "\$" . Str::snake($migration['field_name']) . " = null;\n\t\t\t";
                }
                $fileUploadStmt .= "}\n";
            }
        }

        return $fileUploadStmt;
    }

    protected function getSaveDataStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $saveDataStmt = "";
        foreach ($migrations as $migration) {
            $lastTabs = ",\n\t\t\t\t";
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

    protected function getUpdateDataStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $updateDataStmt = "";
        foreach ($migrations as $migration) {
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

    protected function getDeleteFileStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $deleteFileStmt = "";
        foreach ($migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $deleteFileStmt .= "\$this->deleteStorageFile($" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . ");\n\t\t\t";
                } else {
                    $deleteFileStmt .= "\$this->deleteStorageFiles(json_decode($" . $this->modelEntity . "->" . Str::snake($migration['field_name']) . "));\n\t\t\t";
                }
            }
        }
        return $deleteFileStmt;
    }

    protected function getForeignEntityUseStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $foreignEntityUseStmt = '';
        foreach ($migrations as $migration) {
            if ($migration['data_type'] == 'foreignId') {
                if ($migration['related_model'] != 'auth') {
                    $foreignEntityUseStmt .= "use \\App\\Models\\" . Str::ucfirst($migration['related_model']) . ";\n";
                }
            }
        }
        return $foreignEntityUseStmt;
    }

    protected function getForeignEntityDataStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $foreignEntityDataStmt = '';
        foreach ($migrations as $migration) {
            if ($migration['data_type'] == 'foreignId') {
                if ($migration['related_model'] != 'auth') {
                    $foreignEntityDataStmt .= "$" . Str::snake(Str::plural($migration['related_model'])) . " = " . Str::ucfirst($migration['related_model']) . "::select('id', '" . $migration['related_model_label'] . "')->get();\n\t\t\t\t";
                }
            }
        }
        return $foreignEntityDataStmt;
    }

    protected function getForeignEntityStatement(): string
    {
        $migrations = $this->request->get('migrations');

        $foreignEntityDataStmt = '';
        foreach ($migrations as $migration) {
            if ($migration['data_type'] == 'foreignId') {
                if ($migration['related_model'] != 'auth') {
                    $foreignEntityDataStmt .= ", '" . Str::snake(Str::plural($migration['related_model'])) . "'";
                }
            }
        }
        return $foreignEntityDataStmt;
    }

    protected function getForeignEntityCreateStatement(): string
    {
        $migrations = $this->request->get('migrations');
        $hasForeignId = false;
        $hasAuthModel = false;
        $foreignEntityDataStmt = ", compact(";
        foreach ($migrations as $migration) {
            if ($migration['data_type'] == 'foreignId') {
                if ($migration['related_model'] != 'auth') {
                    $foreignEntityDataStmt .= "'" . Str::snake(Str::plural($migration['related_model'])) . "', ";
                    $hasAuthModel = true;
                }
                $hasForeignId = true;
            }
        }
        $foreignEntityDataStmt .= ")";
        return $hasForeignId && $hasAuthModel ? $foreignEntityDataStmt : "";
    }

    public function rollback(): static
    {
        if (isset($this->controllerName) && !is_null($this->controllerName)) {
            if (isset($this->adminControllerTargetPath) && !is_null($this->adminControllerTargetPath)) {
                $this->deleteFile($this->adminControllerTargetPath);
            }
            if (isset($this->apiControllerTargetPath) && !is_null($this->apiControllerTargetPath)) {
                $this->deleteFile($this->apiControllerTargetPath);
            }
        }
        return $this;
    }
}
