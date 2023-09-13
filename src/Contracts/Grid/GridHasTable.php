<?php

namespace StorePHP\Bundler\Contracts\Grid;

use StorePHP\Bundler\Lib\Grid\Table;

interface GridHasTable
{
    public function table(Table $table);
}
