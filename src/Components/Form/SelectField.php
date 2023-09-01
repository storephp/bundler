<?php

namespace StorePHP\Bundler\Components\Form;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class SelectField extends Component
{
    public function __construct(
        public $label = 'set label',
        public $placeholder = 'set placeholder',
        public $model = 'set name',
        public $options = [],
        public $hint = null,
        public $required = false,
        public $multiple = false,
    ) {
        $this->label = Str::contains($label, '::forms') ? __($label) : $label;
        $this->placeholder = Str::contains($placeholder, '::forms') ? __($placeholder) : $placeholder;
        $this->hint = Str::contains($hint, '::forms') ? __($hint) : $hint;

        if (isset($this->options['model'])) {
            $model = new $this->options['model'];

            $this->options = $model->get()->map(function ($item) {
                return [
                    'label' => $item->{$this->options['row']['label']},
                    'value' => $item->{$this->options['row']['value']},
                ];
            });
        } else {
            $this->options = array_map(function ($item) {
                return [
                    'label' => $item['label'],
                    'value' => $item['value'],
                ];
            }, $options);
        }
    }

    public function render()
    {
        return view('storephp-bundler::builder.components.form.select');
    }
}
