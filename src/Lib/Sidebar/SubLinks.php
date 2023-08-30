<?php

namespace StorePHP\Bundler\Lib\Sidebar;

class SubLinks
{
    private $links = [];

    public function link($icon, $label, $href)
    {
        $link = [
            'icon' => $icon,
            'label' => $label,
            'href' => $href
        ];

        array_push($this->links, $link);

        return $this;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
