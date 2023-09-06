<?php

namespace StorePHP\Bundler;

use StorePHP\Bundler\BundlesDirectory;
use StorePHP\Bundler\Compiling\Admin\FormsAdminCompile;
use StorePHP\Bundler\Compiling\Admin\GridsAdminCompile;
use StorePHP\Bundler\Compiling\Admin\ModulesAdminCompile;
use StorePHP\Bundler\Compiling\Admin\RoutesAdminCompile;
use StorePHP\Bundler\Compiling\Admin\SidebarAdminCompile;
use StorePHP\Bundler\Compiling\FormsCompile;
use StorePHP\Bundler\Compiling\GridsCompile;
use StorePHP\Bundler\Compiling\ModulesCompile;
use StorePHP\Bundler\Compiling\RoutesCompile;
use StorePHP\Bundler\Compiling\SidebarCompile;

class Setup
{
    public function __construct(
        private $modulesPaths = [],
        private $modulesAdminPaths = [],
        private $compiles = [],
        private $adminCompiles = [],
    ) {

        if (BundlesDirectory::hasDirectory()) {
            BundlesDirectory::scan();
        }

        $this->modulesPaths = BundleRegistrar::getPaths(BundleRegistrar::MODULE);
        $this->modulesAdminPaths = BundleRegistrar::getPaths(BundleRegistrar::ADMINMODULE);

        $this->compiles = [
            ModulesCompile::class,
            RoutesCompile::class,
            SidebarCompile::class,
            GridsCompile::class,
            FormsCompile::class,
        ];

        $this->adminCompiles = [
            ModulesAdminCompile::class,
            RoutesAdminCompile::class,
            SidebarAdminCompile::class,
            GridsAdminCompile::class,
            FormsAdminCompile::class,
        ];
    }

    public function run(string $cachePrefix = null)
    {
        foreach ($this->compiles as $compile) {
            $compileObj = new $compile($cachePrefix);
            $compileObj->manage($this->modulesPaths);
        }

        foreach ($this->adminCompiles as $compile) {
            $compileObj = new $compile($cachePrefix);
            $compileObj->manage($this->modulesAdminPaths);
        }
    }
}
