<?php

namespace Adminr\Core\Services;

use Adminr\Core\Contracts\AdminrBuilderInterface;
use Adminr\Core\Traits\HasStubs;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class AdminrResourceInfoBuilderService implements AdminrBuilderInterface
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
            'files' => $this->builderService->resourceInfo->file->resource,
        ]);
    }

    public function prepare(): static
    {
        $stub = $this->processStub($this->getResourceInfoStub('resource'));
        File::put($this->resource->files->path->temp.'/'.$this->resource->files->files, $stub);
        return $this;
    }

    public function processStub(string $stub): array|string
    {
        $stub = str_replace('{{MODEL_CLASS}}', $this->builderService->modelName, $stub);
        $stub = str_replace('{{FILES}}', $this->builderService->modelName, $stub);
        $stub = str_replace('{{REQUESTED_DATA}}', json_encode($this->builderService->request->all()), $stub);
        $stub = str_replace('{{RESOURCE_INFO_ARRAY}}', $this->getResourceInfoStmt(), $stub);
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

    private function getResourceInfoStmt(): string
    {
        $resourceInfoStmt = "{";
        foreach ($this->builderService->resourceInfo->toArray() as $key => $resourceInfo){
            if(is_array($resourceInfo) || is_object($resourceInfo)){
                $resourceInfoStmt .= '"'.$key.'": {';
                foreach ($resourceInfo->toArray() as $i => $rinfs){
                    $resourceInfoStmt .= '"'.$i.'": {';
                    foreach ($rinfs->toArray() as $k => $rinf){
                        if($k == 'path'){
                            if(is_array($rinf['main']) || is_object($rinf['main'])){
                                $resourceInfoStmt .= '"'.$k.'":[';
                                foreach ($rinf['main']->toArray() as $mainPath){
                                    $path = str_replace('\\', '', $mainPath);
                                    $path = collect(explode('Resources', $path))->last();
                                    $path = "adminr/Resources$path";
                                    $resourceInfoStmt .= '"'.$path.'",';
                                }
                                $resourceInfoStmt .= '],';
                            } else {
                                $path = collect(explode('Resources', $rinf['main']))->last();
                                $path = "adminr/Resources$path";
                                $resourceInfoStmt .= '"'.$k.'":"'.$path.'",';
                            }
                        } else {
                            if(is_array($rinf) || is_object($rinf)){
                                $resourceInfoStmt .= '"'.$k.'":'.str_replace('\\', '', $rinf->toJson()).',';
                            } else {
                                $resourceInfoStmt .= '"'.$k.'":"'.$rinf.'",';
                            }
                        }
                    }
                    $resourceInfoStmt .= '},';
                }
                $resourceInfoStmt .= '}';
            } else {
                $resourceInfoStmt .= '"'.$key.'":"'.$resourceInfo.'",';
            }
        }
        $resourceInfoStmt .= "}";
        return $resourceInfoStmt;
    }

}
