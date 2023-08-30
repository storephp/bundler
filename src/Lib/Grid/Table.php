<?php

namespace StorePHP\Bundler\Lib\Grid;

class Table
{
    public $columns = [];

    public function setColumn($label, $dataKey, $filter = null)
    {
        $column = [
            'label' => $label,
            'dataKey' => $dataKey,
            'filter' => $filter,
        ];

        array_push($this->columns, $column);

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
