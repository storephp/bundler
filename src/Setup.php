<?php

namespace StorePHP\Bundler;

use StorePHP\Bundler\BundlesDirectory;
use StorePHP\Bundler\Compiling\RoutesCompile;
use StorePHP\Bundler\Compiling\SidebarCompile;

class Setup
{
    public function __construct(
        private $modulesPaths = [],
        private $compiles = [],
    ) {

        if (BundlesDirectory::hasDirectory()) {
            BundlesDirectory::scan();
        }

        $this->modulesPaths = BundleRegistrar::getPaths(BundleRegistrar::MODULE);

        $this->compiles = [
            RoutesCompile::class,
            SidebarCompile::class,
        ];
    }

    public function run(string $cachePrefix = null)
    {
        foreach ($this->compiles as $compile) {
            $compileObj = new $compile($cachePrefix);
            $compileObj->manage($this->modulesPaths);
        }
    }
}
