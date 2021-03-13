<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ResultsTable extends Component
{
    public $title;
    public $queries;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $queries)
    {
        $this->title = $title;
        $this->queries = $queries;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.results-table');
    }
}
