<?php

namespace Devsbuddy\AdminrEngine\ViewComposers;

use Devsbuddy\AdminrEngine\Models\Menu;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     */
    public function compose(View $view) : void
    {
        $names =  Menu::pluck('name');
        foreach ($names as $name){
            $menus = Menu::where('name', $name)->whereNull('parent')->with('submenus')->get();
            $view->with($name.'Menus', $menus);
        }
    }
}
