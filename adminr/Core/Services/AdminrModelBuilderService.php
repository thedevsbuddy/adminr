<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class AdminrModelBuilderService implements AdminrBuilderInterface
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
            'files' => $this->builderService->resourceInfo->file->model,
        ]);
    }

    public function prepare(): static
    {
        $this->prepareAdminController();
        return $this;
    }

    private function prepareAdminController()
    {
        $stub = $this->builderService->hasSoftDelete
            ? $this->getModelStub('ModelWithSoftdeletes')
            : $this->getModelStub('Model');
        $stub = $this->processStub($stub);
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files, $stub);
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->builderService->modelName, $stub);
        $stub = str_replace('{{TABLE_NAME}}', $this->builderService->tableName, $stub);
        $stub = str_replace('{{RESOURCE_NAME}}', $this->builderService->resourceName, $stub);
        return str_replace('{{MEDIA_ATTRIBUTE_STATEMENT}}', $this->getMediaAttributeStatement(), $stub);
    }

    public function build(): static
    {
        return $this;
    }

    public function rollback(): static
    {
       return $this;
    }

    private function getMediaAttributeStatement(): string
    {
        $mediaAttributeStmt = '';
        foreach ($this->migrations as $migration) {
            if ($migration['data_type'] == 'file') {
                if ($migration['file_type'] == 'single') {
                    $mediaAttributeStmt .= "public function " . Str::camel($migration['field_name']) . "(): Attribute\n\t";
                    $mediaAttributeStmt .= "{\n\t\t";
                    $mediaAttributeStmt .= "return Attribute::make(\n\t\t\t";
                    $mediaAttributeStmt .= "get: function (\$value) {\n\t\t\t\t";
                    $mediaAttributeStmt .= "if (Str::contains(request()->url(), 'api')){\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "return asset(\$value);\n\t\t\t\t";
                    $mediaAttributeStmt .= "}\n\t\t\t\t";
                    $mediaAttributeStmt .= "return \$value;\n\t\t\t";
                } else {
                    $mediaAttributeStmt .= "public function " . Str::camel($migration['field_name']) . "(): Attribute\n\t";
                    $mediaAttributeStmt .= "{\n\t\t";
                    $mediaAttributeStmt .= "return Attribute::make(\n\t\t\t";
                    $mediaAttributeStmt .= "get: function (\$value) {\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "\$return = [];\n\t\t\t";
                    $mediaAttributeStmt .= "if (Str::contains(request()->url(), 'api')){\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "foreach(json_decode(\$value) as \$val){\n\t\t\t\t\t\t";
                    $mediaAttributeStmt .= "\$return[] = asset(\$val);\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "}\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "return \$return;\n\t\t\t\t";
                    $mediaAttributeStmt .= "}\n\t\t\t";
                    $mediaAttributeStmt .= "\$return = [];\n\t\t\t\t";
                    $mediaAttributeStmt .= "foreach(json_decode(\$value) as \$val){\n\t\t\t\t\t";
                    $mediaAttributeStmt .= "\$return[] = \$val;\n\t\t\t\t";
                    $mediaAttributeStmt .= "}\n\t\t\t\t";
                    $mediaAttributeStmt .= "return \$return;\n\t\t\t";
                }
                $mediaAttributeStmt .= "}\n\t\t";
                $mediaAttributeStmt .= ");\n\t";
                $mediaAttributeStmt .= "}\n\n\t";
            }
        }

        return $mediaAttributeStmt;
    }
}
