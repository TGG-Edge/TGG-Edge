<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GlobalExport;

class ExportController extends Controller
{
    public function downloadExcel(Request $request, $model)
    {
        
        // Build FQCN, support nested namespaces (e.g., Admin\Invoice)
        $model = trim($model, '\\/');
        $modelClass = $this->guessModelClass($model);

        if (!class_exists($modelClass)) {
            abort(404, "Model not found: {$modelClass}");
        }

        $user = auth('web2')->user();
        if (!$user) {
            abort(403, 'Unauthenticated');
        }
        

        // Optional: allow passing ownership column override via query param (careful with security)
        $options = [];
        if ($request->has('ownership_column')) {
            $options['ownership_column'] = $request->input('ownership_column');
        }
        if ($request->has('hidden')) {
            // Accept comma-separated hidden columns
            $options['hidden'] = array_filter(explode(',', $request->input('hidden')));
        }

        $fileName = strtolower(class_basename($modelClass)) . '_export_' . now()->format('Ymd_His') . '.xlsx';

        // For moderate sizes:
        return Excel::download(new GlobalExport($modelClass, $user, $options), $fileName);

        // For very large data sets: see Step 8 (queue/chunked export)
    }

    protected function guessModelClass(string $model)
    {
        // If client passed "Invoice" or "invoices", normalize:
        $parts = explode('/', $model);
        $parts = array_map(fn($p) => ucfirst($p), $parts);
        $candidate = 'App\\Models\\' . implode('\\', $parts);

        return $candidate;
    }
}
