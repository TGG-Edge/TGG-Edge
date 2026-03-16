<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;

class GrowthReport implements ReportInterface
{
    public function name(): string
    {
        return "Growth";
    }

    public function type(): string
    {
        return "growth";
    }

    public function generate($query): array
    {
        return [
            'total' => $query->count()
        ];
    }
}   