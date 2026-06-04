<?php

namespace App\View\Components;

use Illuminate\View\Component;

class VentureBenchSupport extends Component
{
    public array $items;
    public string $viewAllUrl;

    public function __construct()
    {
        $this->items = getVentureBenchSupportDashbaordData();

        $this->viewAllUrl = route(
            'tgg-india.venture-bench-services.index',
            ['role' => auth('web2')->user()->role_key]
        );
    }

    public function render()
    {
        return view('components.venture-bench-support');
    }
}