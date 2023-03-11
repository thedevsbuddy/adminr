<?php

namespace Adminr\Core\Http\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModuleHelper
{
    static public function getResources(): ?array
    {
        Cache::forget('resourceList');
        return Cache::remember('resourceList', config('adminr.cache_ttl'), fn () => json_decode(File::get(resourcesPath('resources.json'))));
    }

    static public function getModulesInfo(string $module): ?object
    {
        return json_decode(File::get(resourcesPath(Str::title($module) . "/module.json")));
    }

    static public function writeModulesFile(array $content): void
    {
        File::put(__DIR__ . "/../../modules.json", $content);
    }

    static public function writeModuleFile(string $module, array $content): void
    {
        File::put(resourcesPath(Str::title($module) . "/module.json"), $content);
    }
}
