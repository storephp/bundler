<?php

namespace StorePHP\Bundler\Contracts\Configuration;

use StorePHP\Bundler\Lib\Configuration\Fields;
use StorePHP\Bundler\Lib\Configuration\SubTabs;
use StorePHP\Bundler\Lib\Configuration\Tab;

interface iConfiguration
{
    public function tab(Tab $tab);

    public function subTabs(SubTabs $sub);

    public function fields(Fields $form);
}
