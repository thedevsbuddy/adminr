<?php

namespace Adminr\System\ViewComposers;

use System\Models\Menu;
use Illuminate\View\View;

class MenuComposer
{

    public function compose(View $view): void
    {
        $view->with('menus', ['Some', 'menu', 'items']);

        // $names =  Menu::pluck('name');
        // foreach ($names as $name) {
        //     $menus = Menu::where('name', $name)->whereNull('parent')->with('submenus')->get();
        //     $view->with($name . 'Menus', $menus);
        // }
    }
}
