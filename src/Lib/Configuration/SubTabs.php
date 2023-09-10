<?php

namespace StorePHP\Bundler\Lib\Configuration;

class SubTabs
{
    private $subs = [];

    public function addSub($tabId, $id, $label, $order = 99999)
    {
        array_push($this->subs, [
            'tab_id' => $tabId,
            'id' => $id,
            'label' => $label,
            'order' => $order,
        ]);
    }

    public function getSubs()
    {
        return (!empty($this->subs)) ? $this->subs : array([
            'id' => 'default',
            'label' => 'Default',
        ]);
    }
}
