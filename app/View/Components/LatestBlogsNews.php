<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LatestBlogsNews extends Component
{
    public $latestBlogsAndNews;

    public function __construct($latestBlogsAndNews = null)
    {
        $this->latestBlogsAndNews = $latestBlogsAndNews ?? [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.latest-blogs-news');
    }
}
