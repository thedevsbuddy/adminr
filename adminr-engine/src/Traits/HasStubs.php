<?php

namespace Devsbuddy\AdminrEngine\Traits;


use Devsbuddy\Models\Media;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HasStubs {
    public $stubsDirectory = __DIR__ . '/../../resources/stubs';

    /**
     * @param $controller
     * @param bool $getPath
     * @return string|null
     */
    public function getControllerStub($controller, $getPath = false)
    {
        if(File::exists($this->stubsDirectory . '/controllers/' . $controller . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/controllers/' . $controller . '.stub';
            }
           return File::get($this->stubsDirectory . '/controllers/' . $controller . '.stub');
        }
        return null;
    }

    /**
     * @param $model
     * @param bool $getPath
     * @return string|null
     */
    public function getModelStub($model, $getPath = false)
    {
        if(File::exists($this->stubsDirectory . '/models/' . $model . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/models/' . $model . '.stub';
            }
            return File::get($this->stubsDirectory . '/models/' . $model . '.stub');
        }
        return null;
    }

    /**
     * @param $migration
     * @param bool $getPath
     * @return string|null
     */
    public function getMigrationStub($migration, $getPath = false)
    {
        if(File::exists($this->stubsDirectory . '/database/migrations/' . $migration . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/database/migrations/' . $migration . '.stub';
            }
            return File::get($this->stubsDirectory . '/database/migrations/' . $migration . '.stub');
        }
        return null;
    }

    /**
     * @param $view
     * @param bool $getPath
     * @return string|null
     */
    public function getViewStub($view, $getPath = false)
    {
        if(File::exists($this->stubsDirectory . '/views/' . $view . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/views/' . $view . '.stub';
            }
            return File::get($this->stubsDirectory . '/views/' . $view . '.stub');
        }
        return null;
    }

    /**
     * @param $route
     * @param bool $getPath
     * @return string|null
     */
    public function getRouteStub($route, $getPath = false)
    {
        if(File::exists($this->stubsDirectory . '/routes/' . $route . '.stub')){
            if($getPath){
                return $this->stubsDirectory . '/routes/' . $route . '.stub';
            }
            return File::get($this->stubsDirectory . '/routes/' . $route . '.stub');
        }
        return null;
    }

    /**
     * @param $relationFile
     * @param bool $getPath
     * @return string|null
     */
    public function getRelationStub($relationFile, $getPath = false)
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
