<?php

namespace StorePHP\Bundler\Contracts\Sidebar;

use StorePHP\Bundler\Lib\Sidebar\Links;

interface HasLinks
{
    public function links(Links $links);
}
