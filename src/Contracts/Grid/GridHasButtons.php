<?php

namespace StorePHP\Bundler\Contracts\Grid;

use StorePHP\Bundler\Lib\Grid\Bottom;

interface GridHasButtons
{
    public function createBottom(Bottom $bottom);
}
