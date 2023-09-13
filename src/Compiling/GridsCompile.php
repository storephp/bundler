<?php

namespace StorePHP\Bundler\Compiling;

use Illuminate\Support\Facades\Cache;
use StorePHP\Bundler\Contracts\Grid\GridHasButtons;
use StorePHP\Bundler\Contracts\Grid\GridHasCTA;
use StorePHP\Bundler\Contracts\Grid\GridHasTable;
use StorePHP\Bundler\Lib\Grid\Bottom;
use StorePHP\Bundler\Lib\Grid\CTA;
use StorePHP\Bundler\Lib\Grid\Table;

class GridsCompile
{
    public $count = 0;

    public function __construct(
        protected $cachePrefix = null,
    ) {
    }

    public function mergeGrids($paths)
    {
        $outGrids = [];

        foreach ($paths as $id => $path) {
            $_grid = [];

            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/grids')) {
                foreach (glob($path . DIRECTORY_SEPARATOR . 'etc/grids/*.php') as $filename) {
                    $gridClass = include($filename);
                    $gridClass = new $gridClass;

                    if (!$gridClass instanceof GridHasTable) {
                        throw new \Exception('Must implement `GridHasTable` in ' . $id . '_' . basename($filename, '.php'), 1);
                    }

                    //Columns class
                    $table = new Table;
                    $CTA = new CTA;
                    $bottom = new Bottom;

                    if ($gridClass instanceof GridHasButtons) {
                        $gridClass->createBottom($bottom);
                    }

                    $gridClass->table($table);

                    if ($gridClass instanceof GridHasCTA) {
                        $gridClass->CTA($CTA);
                    }

                    $_grid[$id . '_' . basename($filename, '.php')] = [
                        'model' => $gridClass->model(),
                        'filter' => (method_exists($gridClass, 'filter')) ? $gridClass->filter() : null,
                        'bottoms' => $bottom->getBottoms(),
                        'rows' => $table->getColumns(),
                        'CTAs' => $CTA->getCalls(),
                    ];
                }
                $outGrids = array_merge($outGrids, $_grid);
            }
        }

        return $outGrids;
    }

    public function cacheGrids($grids)
    {
        Cache::forever($this->cachePrefix . 'storephp_grids', $grids);
    }

    public function manage($paths)
    {
        $grids = $this->mergeGrids($paths);
        // dd($grids);
        $this->cacheGrids($grids);
        $this->count = count($grids);
    }
}
