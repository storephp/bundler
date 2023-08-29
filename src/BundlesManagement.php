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
}
