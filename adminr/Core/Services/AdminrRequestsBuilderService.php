<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class AdminrRequestsBuilderService implements AdminrBuilderInterface
{
    use HasStubs;

    protected Fluent $resource;
    protected Array $migrations;
    private AdminrBuilderService $builderService;

    public function __construct(AdminrBuilderService $service)
    {
        $this->builderService = $service;
        $this->migrations = $service->request->get('migrations');
        $this->resource = new Fluent([
            'name' => $this->builderService->resourceInfo->name,
            'files' => $this->builderService->resourceInfo->file->requests,
        ]);
    }

    public function prepare(): static
    {
        $this->prepareRequest();
        $this->prepareUpdateRequest();
        return $this;
    }

    private function prepareRequest()
    {
        $stub = $this->processStub($this->getRequestStub('Request'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->create, $stub);
    }

    private function prepareUpdateRequest()
    {
        $stub = $this->processStub($this->getRequestStub('UpdateRequest'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files->update, $stub);
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->builderService->modelName, $stub);
        $stub = str_replace('{{VALIDATION_RULES}}', $this->getValidationStatement(), $stub);
        $stub = str_replace('{{UPDATE_VALIDATION_RULES}}', $this->getUpdateValidationStatement(), $stub);
        return str_replace('{{RESOURCE_NAME}}', $this->builderService->resourceName, $stub);
    }

    public function build(): static
    {
        return $this;
    }

    public function rollback(): static
    {
        return $this;
    }

    private function getValidationStatement(): string
    {
        $validationStmt = "";
        foreach ($this->migrations as $migration) {
            $lastTabs = ",\n\t\t\t\t";
            if ($migration['data_type'] != 'slug') {
                if ($migration['related_model'] != 'auth') {
                    if ($migration['data_type'] != 'uuid') {
                        if ($migration == $this->migrations[count($this->migrations) - 1]) {
                            $lastTabs = ",\n\t\t\t";
                        }
                        $isUnique = "";
                        if ($migration['unique']) {
                            $isUnique = ", \"unique:" . $this->builderService->tableName . "\"";
                        }
                        if (!$migration['nullable']) {
                            $validationStmt .= "\"" . Str::snake($migration['field_name']) . "\" => [\"required\"" . $isUnique . "]" . $lastTabs;
                        }
                    }
                }
            }
        }
        return $validationStmt;
    }

    private function getUpdateValidationStatement(): string
    {
        $validationStmt = "";
        foreach ($this->migrations as $migration) {
            $lastTabs = ",\n\t\t\t\t";
            if ($migration['data_type'] != 'slug') {
                if ($migration['related_model'] != 'auth') {
                    if ($migration['data_type'] != 'uuid') {
                        if ($migration['data_type'] != 'file') {
                            if ($migration == $this->migrations[count($this->migrations) - 1]) {
                                $lastTabs = "\n\t\t\t";
                            }
                            if (!$migration['nullable']) {
                                $validationStmt .= "\"" . Str::snake($migration['field_name']) . "\" => [\"required\"]" . $lastTabs;
                            }
                        }
                    }
                }
            }
        }
        return $validationStmt;
    }

}
