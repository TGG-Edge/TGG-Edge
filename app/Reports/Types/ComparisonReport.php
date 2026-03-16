<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;

class ComparisonReport implements ReportInterface
{
    public function name(): string
    {
        return "Comparison";
    }

    public function type(): string
    {
        return "comparison";
    }

    public function generate($query): array
    {
        return [
            'current' => $query->count(),
            'previous' => $query->count()
        ];
    }
}