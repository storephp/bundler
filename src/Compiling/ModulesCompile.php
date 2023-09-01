<?php

namespace StorePHP\Bundler\Compiling;

use Illuminate\Support\Facades\Cache;
use StorePHP\Bundler\Lib\Module;

class ModulesCompile
{
    public $count = 0;

    public function __construct(
        protected $cachePrefix = null,
    ) {
    }

    public function merge($paths)
    {
        $outModules = [];

        foreach ($paths as $id => $path) {
            $pathModuleFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'module.php';

            if (!file_exists($pathModuleFile)) {
                throw new \Exception($id . ' => You must create a module.php file');
            }

            $module = new Module;
            $pathModuleFile = require $pathModuleFile;
            $pathModuleFile = new $pathModuleFile;
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
