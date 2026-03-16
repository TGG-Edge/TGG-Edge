<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;
use DB;

class BarChartReport implements ReportInterface
{
    public function name(): string
    {
        return "Bar Chart";
    }

    public function type(): string
    {
        return "bar_chart";
    }

    public function generate($query): array
    {
        return $query
            ->selectRaw("DATE(created_at) as date, COUNT(*) as total")
            ->groupBy("date")
            ->orderBy("date")
            ->limit(10)
            ->get()
            ->toArray();
    }
}