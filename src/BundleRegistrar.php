<?php

namespace StorePHP\Bundler;

class BundleRegistrar
{
    const MODULE = 'module';
    const ADMINMODULE = 'admin_module';

    private static $paths = [
        self::MODULE => [],
        self::ADMINMODULE => [],
    ];

    public static function register($type, $bundleName, $path)
    {
        self::$paths[$type][$bundleName] = str_replace('\\', '/', $path);
    }

    public static function getPaths($type)
    {
        return self::$paths[$type];
    }
}
