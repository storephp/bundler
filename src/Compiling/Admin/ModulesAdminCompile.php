<?php

namespace StorePHP\Bundler\Compiling\Admin;

use Illuminate\Support\Facades\Cache;
use StorePHP\Bundler\Contracts\Module\iModule;
use StorePHP\Bundler\Lib\Module;

class ModulesAdminCompile
{
    public $count = 0;

    public function __construct(
        protected $cachePrefix = null,
    ) {
    }

    public function merge($paths)
    {
        $outModules = Cache::get($this->cachePrefix . 'storephp_modules', []);;

        foreach ($paths as $id => $path) {
            $pathModuleFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'module.php';

            if (!file_exists($pathModuleFile)) {
                throw new \Exception($id . ' => You must create a module.php file');
            }

            $module = new Module;
            $pathModuleFile = require $pathModuleFile;
            $pathModuleFile = new $pathModuleFile;

            if (!$pathModuleFile instanceof iModule) {
                throw new \Exception('Must implement `iModule` in ' . $id, 1);
            }

            $pathModuleFile->info($module);

            $outModules[$id] = array_merge($outModules[$id] ?? [], $module->getInfo());
        }

        return $outModules;
    }

    public function cache($modules)
    {
        Cache::forever($this->cachePrefix . 'storephp_modules', $modules);
    }

    public function manage($paths)
    {
        $modules = $this->merge($paths);
        $this->cache($modules);
        $this->count = count($modules);
    }
}
