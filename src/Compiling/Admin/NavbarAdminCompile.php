<?php

namespace StorePHP\Bundler\Compiling\Admin;

use Illuminate\Support\Facades\Cache;
use StorePHP\Bundler\Contracts\Navbar\HasLinks;
use StorePHP\Bundler\Contracts\Navbar\HasMenu;
use StorePHP\Bundler\Lib\Sidebar\Links;
use StorePHP\Bundler\Lib\Sidebar\Menu;

class NavbarAdminCompile
{
    public $count = 0;

    public function __construct(
        protected $cachePrefix = null,
    ) {
    }

    public function merge($paths)
    {
        $outNavbars = [];

        foreach ($paths as $id => $path) {
            $pathNavbarFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'navbar.php';

            if (file_exists($pathNavbarFile)) {
                $navbar = require $pathNavbarFile;
                $navbar = new $navbar;

                if (!$navbar instanceof HasMenu) {
                    throw new \Exception('Must implement `HasMenu` in ' . $id, 1);
                }

                $link = new Links;
                $menu = new Menu;

                $navbar->menu($menu);

                if ($navbar instanceof HasLinks) {
                    $navbar->links($link);
                }

                $side = [
                    'info' => $menu->getInfo(),
                    'links' => $link->getLinks(),
                ];

                $outNavbars = array_merge($outNavbars, [$id => $side]);
            }
        }

        return $outNavbars;
    }

    public function cache($navbar)
    {
        Cache::forever($this->cachePrefix . 'storephp_admin_navbar', $navbar);
    }

    public function manage($paths)
    {
        $navbar = $this->merge($paths);

        $collection = collect($navbar);

        $sorted = $collection->sortBy(function (array $navbar) {
            return $navbar['info']['order'];
        });

        $this->cache($sorted->all());
        $this->count = count($navbar);
    }
}
