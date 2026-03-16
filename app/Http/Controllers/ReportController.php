<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ModelRelationService;
use App\Reports\Registry\ModelRegistry;
use App\Reports\Engine\ReportEngine;

class ReportController extends Controller
{
    public function models()
    {
        return response()->json(ModelRegistry::all());
    }

    public function relations(Request $request, ModelRelationService $service)
    {
        $model = $request->model;

        $visited = $request->visited ?? [];

        return response()->json(
            $service->getRelations($model, $visited)
        );

        return response()->json(
            $service->getRelations($model)
        );
    }

    public function generate(Request $request)
    {
        if (!$request->model) {
            return response()->json([
                'error' => 'Please select a model'
            ], 422);
        }
        $model = $request->model;

        $relations = $request->relations ?? [];

        $reports = $request->reports ?? ['summary','table','bar_chart'];

        $data = ReportEngine::make($model)
            ->withRelations($relations)
            ->reports($reports)
            ->generate();

        return response()->json($data);
    }
}