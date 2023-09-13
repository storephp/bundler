<?php

namespace StorePHP\Bundler\Contracts\Form;

use StorePHP\Bundler\Lib\Form\Tabs;

interface FormHasTabs
{
    public function tabs(Tabs $tabs);
}
