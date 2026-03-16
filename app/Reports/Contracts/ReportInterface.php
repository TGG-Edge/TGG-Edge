<?php

namespace App\Reports\Contracts;

interface ReportInterface
{
    public function generate($query): array;

    public function name(): string;

    public function type(): string;
}