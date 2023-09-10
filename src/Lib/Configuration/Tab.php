<?php

namespace StorePHP\Bundler\Lib\Configuration;

class Tab
{
    private $tabs = [];

    public function addTab($id, $label, $order = 99999)
    {
        array_push($this->tabs, [
            'id' => $id,
            'label' => $label,
            'order' => $order,
        ]);
    }

    public function getTabs()
    {
        return (!empty($this->tabs)) ? $this->tabs : array([
            'id' => 'default',
            'label' => 'Default',
        ]);
    }
}
