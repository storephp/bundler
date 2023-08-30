<?php

namespace StorePHP\Bundler\Lib\Sidebar;

class Menu
{
    private $info = [];

    public function info($icon, $label)
    {
        $this->info = [
            'icon' => $icon,
            'label' => $label,
        ];
    }

    public function getInfo()
    {
        return $this->info;
    }
}
