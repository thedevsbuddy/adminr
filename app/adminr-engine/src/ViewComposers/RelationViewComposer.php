<?php

namespace Devsbuddy\AdminrEngine\ViewComposers;

use Devsbuddy\AdminrEngine\Models\Menu;
use Illuminate\View\View;

class RelationViewComposer
{
    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view): void
    {
        $relations = [
            [
                'related_entities' => 'role_tests',
                'class' => 'Spatie\Permission\Models\Role',
                'entity_label' => 'name'
            ]
        ];
        foreach ($relations as $relation) {
            $view->with($relation['related_entities'], $relation['class']::select('id', $relation['entity_label'])->get());
        }
    }
}
