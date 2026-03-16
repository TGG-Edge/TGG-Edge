<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;

class TimelineReport implements ReportInterface
{
    public function name(): string
    {
        return "Timeline";
    }

    public function type(): string
    {
        return "timeline";
    }

    public function generate($query): array
    {
        return $query
            ->orderBy('created_at','desc')
            ->limit(20)
            ->get()
            ->toArray();
    }
}