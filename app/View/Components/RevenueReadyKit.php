<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RevenueReadyKit extends Component
{
    public $items;
    public $title;
    public $viewAllLink;

    public function __construct($items, $title = 'Revenue Ready Kit', $viewAllLink = '#')
    {
        $this->items = $items;
        $this->title = "Collaborative Projects";
        $this->viewAllLink = $viewAllLink;
    }

    public function render()
    {
        return view('components.revenue-ready-kit');
    }
}
