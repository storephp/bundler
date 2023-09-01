<?php

namespace StorePHP\Bundler;

use Illuminate\Support\Facades\Cache;

class BundlesManagement
{
    private $cachePrefix = null;

    /**
     * Get the value of cachePrefix
     */
    public function getCachePrefix()
    {
        return $this->cachePrefix;
    }

    /**
     * Set the value of cachePrefix
     *
     * @return  self
     */
    public function setCachePrefix($cachePrefix)
    {
        $this->cachePrefix = $cachePrefix;

        return $this;
    }

    /**
     * Get the value of routes
     */
    public function getRoutes()
    {
        return Cache::get($this->getCachePrefix() . 'storephp_routes');
    }

    /**
     * Get the value of routes
     */
    public function getSidebar()
    {
        return Cache::get($this->getCachePrefix() . 'storephp_sidebar');
    }

    /**
     * Get the value of grids
     */
    public function getGrids($id = null)
    {
        $grids = Cache::get($this->getCachePrefix() . 'storephp_grids');

        if (!is_null($id)) {
            return $grids[$id];
        }

        return $grids;
    }

    /**
     * Get the value of forms
     */
    public function getForms($id = null)
    {
        $forms = Cache::get($this->getCachePrefix() . 'storephp_forms');

        if (!is_null($id)) {
            return $forms[$id];
        }

        return $forms;
    }
}
