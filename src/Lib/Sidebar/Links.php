<?php

namespace StorePHP\Bundler\Lib\Sidebar;

class Links
{
    private $links = [];
    private $pushlinks = [];

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

    public function pushLink($to, $icon, $label, $href)
    {
        $link[$to] = [
            'icon' => $icon,
            'label' => $label,
            'href' => $href
        ];

        $this->pushlinks = array_merge($this->pushlinks, $link);

        return $this;
    }

    public function subLinks($icon, $label, $links, $id = null)
    {
        $sub = new SubLinks;

        $links($sub);

        $_links = [
            'id' => $id,
            'icon' => $icon,
            'label' => $label,
            'sublinks' => $sub->getLinks(),
        ];

        array_push($this->links, $_links);

        return $this;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function getPushLink()
    {
        return $this->pushlinks;
    }
}
