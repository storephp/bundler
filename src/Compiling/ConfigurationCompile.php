<?php

namespace StorePHP\Bundler\Compiling;

use Illuminate\Support\Facades\Cache;
use StorePHP\Bundler\Lib\Configuration\Fields;
use StorePHP\Bundler\Lib\Configuration\SubTabs;
use StorePHP\Bundler\Lib\Configuration\Tab;

class ConfigurationCompile
{
    public $count = 0;

    public function __construct(
        protected $cachePrefix = null,
    ) {
    }

    public function merge($paths)
    {
        $outTabsConfigs = [];
        $outSubTabsConfigs = [];
        $outFieldsConfigs = [];

        foreach ($paths as $id => $path) {
            $pathConfigurationFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'configuration.php';

            if (file_exists($pathConfigurationFile)) {
                $configuration = require $pathConfigurationFile;
                $configuration = new $configuration;

                $tab = new Tab;
                $subtabs = new SubTabs;
                $fields = new Fields;

                $configuration->tab($tab);
                $configuration->subTabs($subtabs);
                $configuration->fields($fields);

                $outTabsConfigs = array_merge($outTabsConfigs, $tab->getTabs());
                $outSubTabsConfigs = array_merge($outSubTabsConfigs, $subtabs->getSubs());
                $outFieldsConfigs = array_merge($outFieldsConfigs, $fields->getFields());
            }
        }

        $subTabs = collect($outSubTabsConfigs)
            ->sortBy(function (array $tab) {
                return $tab['order'];
            })->groupBy(function (array $tab) {
                return $tab['tab_id'];
            });

        $tabs = collect($outTabsConfigs)
            ->map(function (array $tab) use ($subTabs) {
                $tab['sub_tabs'] = $subTabs->toArray()[$tab['id']];
                return $tab;
            })
            ->sortBy(function (array $tab) {
                return $tab['order'];
            });

        $outFields = collect($outFieldsConfigs)
            ->map(function ($field) {
                $field['model'] = $field['tab'] . '_' . $field['model'];
                return $field;
            })->groupBy(function (array $field) {
                return $field['tab'];
            });

        return [
            'tabs' => $tabs->toArray(),
            'fields' => $outFields->toArray(),
        ];
    }

    public function cache($configuration, $fields)
    {
        Cache::forever($this->cachePrefix . 'storephp_configuration', $configuration);
        Cache::forever($this->cachePrefix . 'storephp_configuration_fields', $fields);
    }

    public function manage($paths)
    {
        $configs = $this->merge($paths);

        $this->cache($configs['tabs'], $configs['fields']);
        $this->count = count($configs);
    }
}
