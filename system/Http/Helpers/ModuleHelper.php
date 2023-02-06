<?php

namespace Adminr\System\Http\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModuleHelper
{
    static public function getModules(): ?array
    {
        return Cache::remember('modulesList', config('adminr.cache_remember_time'), fn () => json_decode(File::get(__DIR__ . "/../../modules.json")));
    }

    static public function getModulesInfo(string $module): ?object
    {
        return json_decode(File::get(module_path(Str::title($module) . "/module.json")));
    }

    static public function writeModulesFile(array $content): void
    {
        File::put(__DIR__ . "/../../modules.json", $content);
    }

    static public function writeModuleFile(string $module, array $content): void
    {
        File::put(module_path(Str::title($module) . "/module.json"), $content);
    }
}
