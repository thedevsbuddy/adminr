<?php

namespace Adminr\Core\ViewComposers;

use Adminr\Core\Http\Helpers\ModuleHelper;
use Adminr\Core\Support\Rayson;
use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view): void
    {
        $resourceArray = new Rayson(collect(ModuleHelper::getResources())->filter(fn($r) => $r->type == 'module')->toArray());
        $view->with('resources', $resourceArray->toArray());
    }
}
