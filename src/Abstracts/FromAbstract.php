<?php

namespace StorePHP\Bundler\Abstracts;

use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use StorePHP\Bundler\Facades\Bundles;

abstract class FromAbstract extends Component
{
    use LivewireAlert;

    protected $pretitle = 'Pre Title';
    protected $title = 'Title';

    private $fields = [];

    public function boot()
    {
        $this->fields = Bundles::getForms($this->formId)['fields'];

        foreach ($this->fields as $field) {
            $this->{$field['model']} = $field['value'] ?? null;
        }
    }

    public function preTitle()
    {
        return Str::contains($this->pretitle, '::forms') ? __($this->pretitle) : $this->pretitle;
    }

    public function title()
    {
        return Str::contains($this->title, '::forms') ? __($this->title) : $this->title;
    }

    protected function rules()
    {
        $data = [];

        foreach ($this->fields as $field) {
            $data[$field['model']] = $field['rules'];
        }

        return $data;
    }

    public function render()
    {
        return view('storephp-bundler::builder.form', [
            'pretitle' => $this->preTitle(),
            'title' => $this->title(),
        ])->layout($this->layout());
    }

    protected function layout()
    {
        //
    }

    protected function pushAlert($type = 'success', $massage)
    {
        $this->alert($type, $massage, [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }
}
