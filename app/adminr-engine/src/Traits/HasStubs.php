<?php

namespace Devsbuddy\AdminrEngine\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HasStubs {
    public string $stubsDirectory = __DIR__ . '/../../resources/stubs';

    public function getControllerStub($controller, $getPath = false): ?string
    {
        if(File::exists($this->stubsDirectory . '/controllers/' . $controller . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/controllers/' . $controller . '.stub';
            }
           return File::get($this->stubsDirectory . '/controllers/' . $controller . '.stub');
        }
        return null;
    }

    public function getModelStub($model, $getPath = false): ?string
    {
        if(File::exists($this->stubsDirectory . '/models/' . $model . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/models/' . $model . '.stub';
            }
            return File::get($this->stubsDirectory . '/models/' . $model . '.stub');
        }
        return null;
    }

    public function getMigrationStub($migration, $getPath = false): ?string
    {
        if(File::exists($this->stubsDirectory . '/database/migrations/' . $migration . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/database/migrations/' . $migration . '.stub';
            }
            return File::get($this->stubsDirectory . '/database/migrations/' . $migration . '.stub');
        }
        return null;
    }

    public function getViewStub($view, $getPath = false): ?string
    {
        if(File::exists($this->stubsDirectory . '/views/' . $view . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/views/' . $view . '.stub';
            }
            return File::get($this->stubsDirectory . '/views/' . $view . '.stub');
        }
        return null;
    }

    public function getRouteStub($route, $getPath = false): ?string
    {
        if(File::exists($this->stubsDirectory . '/routes/' . $route . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/routes/' . $route . '.stub';
            }
            return File::get($this->stubsDirectory . '/routes/' . $route . '.stub');
        }
        return null;
    }

    public function getResourceStub($resourceFile, $getPath = false): ?string
    {
        if(File::exists($this->stubsDirectory . '/resources/' . $resourceFile . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/resources/' . $resourceFile . '.stub';
            }
            return File::get($this->stubsDirectory . '/resources/' . $resourceFile . '.stub');
        }
        return null;
    }

    public function getRelationStub($relationFile, $getPath = false): ?string
    {
        if(File::exists($this->stubsDirectory . '/relations/' . $relationFile . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/relations/' . $relationFile . '.stub';
            }
            return File::get($this->stubsDirectory . '/relations/' . $relationFile . '.stub');
        }
        return null;
    }


}
