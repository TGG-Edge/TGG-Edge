<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;

class SummaryReport implements ReportInterface
{
    public function name(): string
    {
        return "Summary Report";
    }

    public function type(): string
    {
        return "summary";
    }

    public function generate($query): array
    {
        return [
            'total_records' => $query->count()
        ];
    }
}