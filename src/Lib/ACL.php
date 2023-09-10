<?php

namespace StorePHP\Bundler\Lib;

class ACL
{
    public $permissions = [];

    public function permission($label, $key)
    {
        array_push($this->permissions, [
            'label' => $label,
            'key' => $key,
        ]);

        return $this;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }
}
