<?php

namespace StorePHP\Bundler\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use StorePHP\Bundler\Facades\Bundles;

class FormBuilder extends Component
{
    public $method = 'POST';
    public $action = null;
    public $groupFields = [];
    public $mainTab = [];
    public $tabs = [];

    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($id = null, $method = 'POST', $action = null)
    {
        $this->method = $method;
        $this->action = $action;

        $collection = collect(Bundles::getForms($id)['fields']);
        $grouped = $collection->groupBy('tab');

        $this->groupFields = $grouped->toArray();
        $this->mainTab = Bundles::getForms($id)['tabs'][0];
        $this->tabs = Bundles::getForms($id)['tabs'];
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('storephp-bundler::builder.components.form');
    }
}
