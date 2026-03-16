<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;

class LineChartReport implements ReportInterface
{
    public function name(): string
    {
        return "Line Chart";
    }

    public function type(): string
    {
        return "line_chart";
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