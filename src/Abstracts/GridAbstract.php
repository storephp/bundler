<?php

namespace StorePHP\Bundler\Abstracts;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use StorePHP\Bundler\Facades\Bundles;
use StorePHP\Bundler\Lib\Builder\Grid;

abstract class GridAbstract extends Component
{
    use WithPagination;

    protected $pretitle = 'Pre Title Grid';
    protected $title = 'Title Grid';
    protected $paginationTheme = 'bootstrap';

    private $grid = null;

    public function boot()
    {
        $grid = Bundles::getGrids($this->gridId);

        $gridBuild = Grid::model($grid['model']);

        $gridBuild->setBottoms($grid['bottoms']);

        foreach ($grid['rows'] as $row) {
            $gridBuild->addColumn($row['label'], $row['dataKey'], $row['filter']);
        }

        $gridBuild->setCTAs($grid['CTAs']);
        $gridBuild->initFilter($grid['filter']);

        $this->grid = $gridBuild;
    }

    public function preTitle()
    {
        return Str::contains($this->pretitle, '::grids') ? __($this->pretitle) : $this->pretitle;
    }

    public function title()
    {
        return Str::contains($this->title, '::grids') ? __($this->title) : $this->title;
    }

    public function render()
    {
        return view('storephp-bundler::builder.grid', [
            'pretitle' => $this->preTitle(),
            'title' => $this->title(),
            'grid' => $this->grid,
            'canRemoveRow' => method_exists($this, 'removeRow'),
        ])->layout($this->layout());
    }

    protected function layout()
    {
        //
    }
}
