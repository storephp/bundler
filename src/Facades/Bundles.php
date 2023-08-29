<?php

namespace StorePHP\Bundler\Facades;

use Illuminate\Support\Facades\Facade;

class Bundles extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bundles';
    }
}
