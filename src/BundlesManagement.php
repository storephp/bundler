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
     * Get the value of admin routes
     */
    public function getAdminRoutes()
    {
        return Cache::get($this->getCachePrefix() . 'storephp_admin_routes');
    }

    /**
     * Get the value of routes
     */
    public function getSidebar()
    {
        return Cache::get($this->getCachePrefix() . 'storephp_sidebar');
    }

    /**
     * Get the value of admin navbar
     */
    public function getAdminNavbar()
    {
        return Cache::get($this->getCachePrefix() . 'storephp_admin_navbar');
    }

    /**
     * Get the value of modules
     */
    public function getModules($id = null)
    {
        $modules = Cache::get($this->getCachePrefix() . 'storephp_modules');

        if (!is_null($id)) {
            return $modules[$id];
        }

        return $modules;
    }

    /**
     * Get the value of provoiders
     */
    public function getProvoiders()
    {
        $modules = $this->getModules();

        $outProvoiders = [];

        if ($modules) {
            foreach ($modules as $module) {
                $outProvoiders = array_merge($outProvoiders, $module['provoiders']);
            }
        }

        return $outProvoiders;
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

    /**
     * Get the value of ACLs
     */
    public function getACLs()
    {
        return Cache::get($this->getCachePrefix() . 'storephp_acls');
    }

    /**
     * Get the value of ACLs
     */
    public function getPermissions()
    {
        $acls = $this->getACLs();

        $outAcls = [];

        foreach ($acls as $key => $acl) {
            foreach ($acl as $a) {
                array_push($outAcls, $a);
            }
        }

        return $outAcls;
    }

    /**
     * Get the value of configuration
     */
    public function getTabsConfiguration()
    {
        return Cache::get($this->getCachePrefix() . 'storephp_configuration');
    }

    /**
     * Get the fields of configuration
     */
    public function getTabsFieldsConfiguration($tab = null)
    {
        $fields = Cache::get($this->getCachePrefix() . 'storephp_configuration_fields');

        if (!is_null($tab)) {
            return $fields[$tab];
        }

        return $fields;
    }
}
