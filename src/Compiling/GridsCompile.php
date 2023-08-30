<?php

namespace StorePHP\Bundler\Compiling;

use Illuminate\Support\Facades\Cache;
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

                    //Columns class
                    $table = new Table;
                    $CTA = new CTA;
                    $bottom = new Bottom;

                    if (method_exists($gridClass, 'createBottom')) {
                        $gridClass->createBottom($bottom);
                    }

                    $gridClass->table($table);
                    $gridClass->CTA($CTA);

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
