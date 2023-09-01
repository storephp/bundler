<?php

namespace StorePHP\Bundler\Lib;

class Module
{
    public $info = [
        'name' => 'name',
        'version' => '0.0.0',
        'provoiders' => [],
    ];

    public function name($name)
    {
        $this->info = array_merge($this->info, [
            'name' => $name,
        ]);

        return $this;
    }

    public function provoiders(array $provoiders = [])
    {
        $this->info = array_merge($this->info, [
            'provoiders' => $provoiders,
        ]);

        return $this;
    }

    public function getInfo()
    {
        return $this->info;
    }
}
