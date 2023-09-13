<?php

namespace StorePHP\Bundler\Contracts\Module;

use StorePHP\Bundler\Lib\Module;

interface iModule
{
    public function info(Module $module);
}
