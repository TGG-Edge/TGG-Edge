<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HappinessProgram extends Component
{
    public $showcase;

    public function __construct($showcase)
    {
        $this->showcase = $showcase;
    }

    public function render()
    {
        return view('components.happiness-program');
    }
}
