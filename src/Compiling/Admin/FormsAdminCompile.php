<?php

namespace StorePHP\Bundler\Compiling\Admin;

use Illuminate\Support\Facades\Cache;
use StorePHP\Bundler\Contracts\Form\FormHasFields;
use StorePHP\Bundler\Contracts\Form\FormHasTabs;
use StorePHP\Bundler\Lib\Form\Fields;
use StorePHP\Bundler\Lib\Form\Tabs;

class FormsAdminCompile
{
    public $count = 0;

    public function __construct(
        protected $cachePrefix = null,
    ) {
    }

    public function mergeForms($paths)
    {
        $outForms = Cache::get($this->cachePrefix . 'storephp_forms', []);;

        foreach ($paths as $id => $path) {
            $_form = [];

            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/forms')) {

                foreach (glob($path . DIRECTORY_SEPARATOR . 'etc/forms' . DIRECTORY_SEPARATOR . '*.php') as $filename) {
                    $formClass = include($filename);

                    $fields = new Fields;

                    if (!$formClass instanceof FormHasFields) {
                        throw new \Exception('Must implement `FormHasFields` in ' . $id . '_' . basename($filename, '.php'), 1);
                    }

                    $tabs = new Tabs;

                    (new $formClass)->fields($fields);

                    if ($formClass instanceof FormHasTabs) {
                        (new $formClass)->tabs($tabs);
                    }

                    (new $formClass)->tabs($tabs);

                    $formId = $id . '_' . basename($filename, '.php');

                    if (isset($this->appendFields($paths)[$formId])) {
                        $fields->mergeFields($this->appendFields($paths)[$formId]);
                    }

                    $_form[$id . '_' . basename($filename, '.php')] = [
                        'tabs' => $tabs->getTabs(),
                        'fields' => $fields->getFields(),
                    ];
                }

                $outForms = array_merge($outForms, $_form);
            }
        }

        return $outForms;
    }

    public function cacheForms($forms)
    {
        Cache::forever($this->cachePrefix . 'storephp_forms', $forms);
    }

    public function manage($paths)
    {
        $forms = $this->mergeForms($paths);
        $this->cacheForms($forms);
        $this->count = count($forms);
    }

    /**
     * Append external fields
     * 
     * Example:-
        use Obelaw\Framework\Builder\Form\Fields;

        return new class
        {
            public $appendTo = '<form_id>';

            public function form(Fields $form)
            {
                ...
            }
        };
     */
    public function appendFields($paths)
    {
        $outfields = [];

        foreach ($paths as $id => $path) {
            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/forms' . DIRECTORY_SEPARATOR . 'appends')) {
                foreach (glob($path . DIRECTORY_SEPARATOR . 'etc/forms' . DIRECTORY_SEPARATOR . 'appends' . DIRECTORY_SEPARATOR . '*.php') as $filename) {
                    $formClass = include($filename);

                    $fields = new Fields;

                    $formClass = new $formClass;

                    $formClass->fields($fields);

                    $outfields[$formClass->appendTo] = array_merge($outfields[$formClass->appendTo] ?? [], $fields->getFields());
                }
            }
        }

        return $outfields;
    }
}
