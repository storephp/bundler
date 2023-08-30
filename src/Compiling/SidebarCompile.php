<?php

namespace StorePHP\Bundler\Compiling;

use Illuminate\Support\Facades\Cache;
use StorePHP\Bundler\Lib\Sidebar\Links;
use StorePHP\Bundler\Lib\Sidebar\Menu;

class SidebarCompile
{
    public $count = 0;

    public function __construct(
        protected $cachePrefix = null,
    ) {
    }

    public function merge($paths)
    {
        $outSidebars = [];

        foreach ($paths as $id => $path) {
            $pathSidebarFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'sidebar.php';

            if (file_exists($pathSidebarFile)) {
                $sidebar = require $pathSidebarFile;
                $sidebar = new $sidebar;

                $link = new Links;
                $menu = new Menu;

                $sidebar->menu($menu);

                $sidebar->links($link);

                $side = [
                    'info' => $menu->getInfo(),
                    'links' => $link->getLinks(),
                ];

                $outSidebars = array_merge($outSidebars, [$id => $side]);
            }
        }

        return $outSidebars;
    }

    public function cache($sidebar)
    {
        Cache::forever($this->cachePrefix . 'storephp_sidebar', $sidebar);
    }

    public function manage($paths)
    {
        $sidebar = $this->merge($paths);
        $this->cache($sidebar);
        $this->count = count($sidebar);
    }
}
