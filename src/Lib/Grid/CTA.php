<?php

namespace StorePHP\Bundler\Lib\Grid;

class CTA
{
    public $calls = [];

    public function setCall($label, $route)
    {
        $this->calls = array_merge($this->calls, [$label => $route]);

        return $this;
    }

    public function getCalls()
    {
        return $this->calls;
    }
}
