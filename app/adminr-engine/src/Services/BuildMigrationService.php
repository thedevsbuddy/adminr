<?php

namespace Devsbuddy\AdminrEngine\Services;

use Devsbuddy\AdminrEngine\Database;
use Devsbuddy\AdminrEngine\Traits\CanManageFiles;
use Devsbuddy\AdminrEngine\Traits\HasStubs;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BuildMigrationService extends AdminrEngineService
{
    protected string $migrationTargetPath;

    public function prepare(Request $request): static
    {
        parent::prepare($request);
        $this->migrationTargetPath = database_path() . "/migrations/$this->migrationFileName.php";
        return $this;
    }

    public function buildMigration(): static
    {
        try {
            $migrationStub = $this->getMigrationStub('migration');
            $stubPath = $this->getMigrationStub('migration', true);
            $migrationStub = $this->processStub($migrationStub);
            $this->makeDirectory($this->migrationTargetPath);
            File::put($stubPath, $migrationStub);
            File::copy($stubPath, $this->migrationTargetPath);

            return $this;
        } catch (\Exception | \Error $e) {
            throw $e;
        }
    }

    public function processStub($stub): array|string
    {
        $stub = str_replace('{{PLURAL_MODEL_NAME}}', $this->modelPluralName, $stub);
        $stub = str_replace('{{TABLE_NAME}}', $this->tableName, $stub);
        return str_replace('{{MIGRATION_STATEMENT}}', $this->getMigrationStatement(), $stub);
    }

    protected function getMigrationStatement(): string
    {
        $migrations = $this->request->get('migrations');
        $numericDatatypes = Database::numericTypes();
        $integerTypes = Database::integerTypes();
        $migrationFileStmt = '';
        foreach ($migrations as $migration) {
            if ($migration['field_name'] != 'id') {
                $enumValues = "";
                if ($migration['data_type'] == 'enum') {
                    $enumValsArr = explode(',', $migration['enum_values']);
                    $enumVals = "";
                    foreach ($enumValsArr as $enumVal) {
                        if ($enumVal == end($enumValsArr)) {
                            $enumVals .= "\"" . trim($enumVal) . "\"";
                        } else {
                            $enumVals .= "\"" . trim($enumVal) . "\", ";
                        }
                    }
                    $enumValues = ", [" . $enumVals . "]";
                }

                if ($migration['data_type'] == 'slug') {
                    $data_type = "string";
                } elseif ($migration['data_type'] == 'file') {
                    if ($migration['file_type'] == 'single') {
                        $data_type = "string";
                    } else {
                        $data_type = "text";
                    }
                } else {
                    $data_type = $migration['data_type'];
                }

                if ($migration['data_type'] == 'foreignId') {
                    $data_type = "foreignId";
                    $constrained = "->constrained()->cascadeOnDelete()";
                } else {
                    $constrained = "";
                }
                $migrationFileStmt .= "\$table->" . $data_type . "(\"" . Str::snake($migration['field_name']) . "\"" . $enumValues . ")" . $constrained;
                if ($migration['unique']) {
                    $migrationFileStmt .= "->unique()";
                }
                if ($migration['nullable']) {
                    $migrationFileStmt .= "->nullable()";
                }
                $default = $migration['default'];

                // Cast default values properly
                if (in_array($migration['data_type'], $numericDatatypes)) {
                    $default = floatval($default);
                }

                if (in_array($migration['data_type'], $integerTypes)) {
                    $default = intval($default);
                }

                if (!is_null($default)) {
                    $defaultVal = is_numeric($default) ? $default : "\"" . $default . "\"";
                    $migrationFileStmt .= "->default(" . $defaultVal . ")";
                }
                $migrationFileStmt .= ";\n\t\t\t";
            }
        }

        $migrationFileStmt .= "\$table->timestamps();";

        if ($this->hasSoftdeletes) {
            $migrationFileStmt .= "\n\t\t\t\$table->softDeletes();";
        }

        return $migrationFileStmt;
    }

    public function rollback(): static
    {
        if (isset($this->migrationFileName) && !is_null($this->migrationFileName)) {
            if (isset($this->migrationTargetPath) && !is_null($this->migrationTargetPath)) {
                $this->deleteFile($this->migrationTargetPath);
            }
        }
        return $this;
    }

}
