<?php

namespace StorePHP\Bundler\Lib\Form;

class Tabs
{
    private $tabs = [];

    public function addTab($id, $label)
    {
        array_push($this->tabs, [
            'id' => $id,
            'label' => $label,
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
