<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;

class PieChartReport implements ReportInterface
{
    public function name(): string
    {
        return "Pie Chart";
    }

    public function type(): string
    {
        return "pie_chart";
    }

    public function generate($query): array
    {
        return $query
            ->selectRaw("COUNT(*) as total")
            ->limit(5)
            ->get()
            ->toArray();
    }
}