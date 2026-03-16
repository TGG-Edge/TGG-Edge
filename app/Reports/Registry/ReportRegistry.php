<?php

namespace App\Reports\Registry;

use App\Reports\Types\SummaryReport;
use App\Reports\Types\TableReport;
use App\Reports\Types\BarChartReport;
use App\Reports\Types\LineChartReport;
use App\Reports\Types\PieChartReport;
use App\Reports\Types\TopRecordsReport;
use App\Reports\Types\ComparisonReport;
use App\Reports\Types\TimelineReport;
use App\Reports\Types\GrowthReport;

class ReportRegistry
{
    public static function all(): array
    {
        return [

            'summary' => SummaryReport::class,

            'table' => TableReport::class,

            'bar_chart' => BarChartReport::class,

            'line_chart' => LineChartReport::class,

            'pie_chart' => PieChartReport::class,

            'top_records' => TopRecordsReport::class,

            'comparison' => ComparisonReport::class,

            'timeline' => TimelineReport::class,

            'growth' => GrowthReport::class,

        ];
    }

    public static function make(string $type)
    {
        $reports = self::all();

        if (!isset($reports[$type])) {
            throw new \Exception("Report type {$type} not found");
        }

        return app($reports[$type]);
    }
}