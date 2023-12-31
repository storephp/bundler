<?php

namespace StorePHP\Bundler\Lib\Form;

use Exception;

class Fields
{
    private $fields = [];

    public function addField($type = 'text', $attributes, $tab = 'default')
    {
        $attributes = match ($type) {
            'text' => $this->handleText($attributes),
            'textarea' => $this->handleTextArea($attributes),
            'file' => $this->handleFile($attributes),
            'date' => $this->handleDate($attributes),
            'select' => $this->handleSelect($attributes),
            'checkbox' => $this->handleCheckbox($attributes),
        };

        $attributes['tab'] = $tab;

        $this->fields[] = $attributes;
    }

    public function mergeFields($fields)
    {
        $this->fields = array_merge($this->fields, $fields);
    }

    /**
     * Get the value of fields
     */
    public function getFields()
    {
        return array_map(function ($field) {
            $field['hint'] = (isset($field['hint'])) ? $field['hint'] : null;
            return $field;
        }, $this->fields);
    }

    private function handleText($attributes)
    {
        $attributes['type'] = 'text';
        return $this->falterAttributes($attributes);
    }

    private function handleTextArea($attributes)
    {
        $attributes['type'] = 'textarea';
        return $this->falterAttributes($attributes);
    }

    private function handleFile($attributes)
    {
        $attributes['type'] = 'file';
        return $this->falterAttributes($attributes);
    }

    private function handleDate($attributes)
    {
        $attributes['type'] = 'date';
        return $this->falterAttributes($attributes);
    }

    private function handleSelect($attributes)
    {
        $keysAttributes = array_keys($attributes);

        if (!in_array('options', $keysAttributes)) {
            throw new Exception('The ' . $attributes['model'] . ' field must contain the options', 1);
        }

        $attributes['type'] = 'select';
        $attributes['multiple'] = $attributes['multiple'] ?? false;
        return $this->falterAttributes($attributes);
    }

    private function handleCheckbox($attributes)
    {
        $attributes['type'] = 'checkbox';
        return $this->falterAttributes($attributes);
    }

    private function falterAttributes($attributes)
    {
        return $attributes;
    }
}
