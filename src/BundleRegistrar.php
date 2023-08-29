<?php

namespace StorePHP\Bundler;

class BundleRegistrar
{
    const MODULE = 'module';

    private static $paths = [
        self::MODULE => [],
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
