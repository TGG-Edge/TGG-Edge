<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;

class TableReport implements ReportInterface
{
    public function name(): string
    {
        return "Table Report";
    }

    public function type(): string
    {
        return "table";
    }

    public function generate($query): array
    {
        return $query->limit(50)->get()->toArray();
    }
}