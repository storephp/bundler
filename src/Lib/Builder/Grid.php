<?php

namespace StorePHP\Bundler\Lib\Builder;

use StorePHP\Bundler\Lib\Builder\Grid\Table;

class Grid
{
    public static function model($model = null)
    {
        return new Table($model);
    } 
}
