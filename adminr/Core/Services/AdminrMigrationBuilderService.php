<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Database;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class AdminrMigrationBuilderService implements AdminrBuilderInterface
{
    use HasStubs;

    protected Fluent $resource;
    protected array $migrations;
    private AdminrBuilderService $builderService;

    public function __construct(AdminrBuilderService $service)
    {
        $this->builderService = $service;
        $this->migrations = $service->request->get('migrations');
        $this->resource = new Fluent([
            'name' => $this->builderService->resourceInfo->name,
            'files' => $this->builderService->resourceInfo->file->migration,
        ]);
    }

    public function prepare(): static
    {
        $stub = $this->processStub($this->getMigrationStub('migration'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->migration, $stub);
        return $this;
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{PLURAL_MODEL_NAME}}', $this->builderService->modelPluralName, $stub);
        $stub = str_replace('{{TABLE_NAME}}', $this->builderService->tableName, $stub);
        return str_replace('{{MIGRATION_STATEMENT}}', $this->getMigrationStatement(), $stub);
    }

    public function build(): static
    {
        return $this;
    }

    public function rollback(): static
    {
       return $this;
    }

    private function getMigrationStatement(): string
    {
        $numericDatatypes = Database::numericTypes();
        $integerTypes = Database::integerTypes();
        $migrationFileStmt = '';
        foreach ($this->migrations as $migration) {
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

        if ($this->builderService->hasSoftDelete) {
            $migrationFileStmt .= "\n\t\t\t\$table->softDeletes();";
        }

        return $migrationFileStmt;
    }

}
