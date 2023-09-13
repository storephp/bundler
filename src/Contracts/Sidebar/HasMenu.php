<?php

namespace StorePHP\Bundler\Contracts\Sidebar;

use StorePHP\Bundler\Lib\Sidebar\Menu;

interface HasMenu
{
    public function menu(Menu $menu);
}
