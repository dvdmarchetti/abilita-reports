<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $value;
    public $rate;
    public $since;
    public $color;
    public $icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $value, $color = null, $icon = null, $rate = null, $since = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->rate = $rate;
        $this->since = $since;
        $this->color = $color ?? 'bg-red-500';
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card');
    }
}
