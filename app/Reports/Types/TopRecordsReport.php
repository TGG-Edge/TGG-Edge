<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;

class TopRecordsReport implements ReportInterface
{
    public function name(): string
    {
        return "Top Records";
    }

    public function type(): string
    {
        return "top_records";
    }

    public function generate($query): array
    {
        return $query
            ->latest()
            ->limit(10)
            ->get()
            ->toArray();
    }
}