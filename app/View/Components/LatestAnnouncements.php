<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LatestAnnouncements extends Component
{
    public $announcements;

    public function __construct($announcements = null)
    {
        $this->announcements = $announcements ?? getLatestAnnouncements();
    }

    public function render()
    {
        return view('components.latest-announcements');
    }
}