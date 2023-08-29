<?php

namespace StorePHP\Bundler;

class BundlesDirectory
{
    private static $directoryPaths = [];

    /**
     * Set the value of directoryPaths
     *
     */
    public static function setDirectoryPath($directoryPath)
    {
        array_push(static::$directoryPaths, $directoryPath);
    }

    /**
     * Set the value of directoryPaths
     *
     */
    public static function hasDirectory()
    {
        return (count(static::$directoryPaths) != 0) ? true : false;
    }

    public static function scan()
    {
        foreach (static::$directoryPaths as $path) {
            foreach (glob($path . '/**/*/storephp.php') as $storephp) {
                require $storephp;
            }
        }
    }
}
