<?php

namespace StorePHP\Bundler\Compiling;

use Illuminate\Support\Facades\Cache;
use StorePHP\Bundler\Contracts\Sidebar\HasLinks;
use StorePHP\Bundler\Contracts\Sidebar\HasMenu;
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

                if (!$sidebar instanceof HasMenu) {
                    throw new \Exception('Must implement `HasMenu` in ' . $id, 1);
                }

                $link = new Links;
                $menu = new Menu;

                $sidebar->menu($menu);

                if ($sidebar instanceof HasLinks) {
                    $sidebar->links($link);
                }

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

        $collection = collect($sidebar);

        $sorted = $collection->sortBy(function (array $sidebar) {
            return $sidebar['info']['order'];
        });

        $this->cache($sorted->all());
        $this->count = count($sidebar);
    }
}
