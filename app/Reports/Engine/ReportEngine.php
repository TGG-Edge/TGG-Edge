<?php

namespace App\Reports\Engine;

use App\Reports\Registry\ReportRegistry;

class ReportEngine
{
    protected string $model;

    protected array $relations = [];

    protected array $reports = [];

    public static function make(string $model)
    {
        $instance = new self;

        $instance->model = $model;

        return $instance;
    }

    public function withRelations(array $relations)
    {
        $this->relations = $relations;

        return $this;
    }

    public function reports(array $reports)
    {
        $this->reports = $reports;

        return $this;
    }

    public function generate(): array
    {
        $query = $this->model::query()->with($this->relations);

        $results = [];

        foreach ($this->reports as $reportType) {

            $report = ReportRegistry::make($reportType);

            $results[$reportType] = $report->generate(clone $query);
        }

        return $results;
    }
}