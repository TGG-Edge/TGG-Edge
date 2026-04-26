<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FreelanceOpportunities extends Component
{
    public $opportunities;

    public function __construct($opportunities = [])
    {
        $this->opportunities = $opportunities;
    }

    public function render()
    {
        return view('components.freelance-opportunities');
    }
}
