<?php

namespace StorePHP\Bundler\Contracts\Form;

use StorePHP\Bundler\Lib\Form\Fields;

interface FormHasFields
{
    public function fields(Fields $form);
}
