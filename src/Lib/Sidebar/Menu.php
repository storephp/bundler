<?php

namespace StorePHP\Bundler\Lib\Sidebar;

class Menu
{
    private $info = [];

    public function info($icon, $label, $href = null, $order = 0)
    {
        $this->info = [
            'icon' => $icon,
            'label' => $label,
            'href' => $href,
            'order' => $order,
        ];
    }

    public function getInfo()
    {
        return $this->info;
    }
}
