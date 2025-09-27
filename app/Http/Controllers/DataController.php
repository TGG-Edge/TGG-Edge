<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    public function showUploadForm()
    {
        return view('sheet.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $arrays = Excel::toArray([], $request->file('file'));

        // take first sheet
        $sheet = $arrays[0] ?? [];

        if (empty($sheet)) {
            return back()->with('error', 'Uploaded sheet is empty or could not be read.');
        }

        // detect if first row is header-like
        $firstRow = $sheet[0];
        $hasHeader = $this->rowLooksLikeHeader($firstRow);

        if ($hasHeader) {
            $headers = array_map(function($h){ return (string)trim($h) ?: 'Column'; }, $firstRow);
            array_shift($sheet); // remove header row
        } else {
            // Create generic headers Column 1..N
            $colCount = count($firstRow);
            $headers = [];
            for ($i = 0; $i < $colCount; $i++) {
                $headers[] = 'Column ' . ($i + 1);
            }
        }

        // Build columns: header => [values...]
        $columns = [];
        $rowCount = count($sheet);
        foreach ($headers as $i => $header) {
            $col = [];
            for ($r = 0; $r < $rowCount; $r++) {
                $val = $sheet[$r][$i] ?? null;
                $col[] = $this->cleanCellValue($val);
            }
            $columns[$header] = $col;
        }

        // Detect numeric vs string columns
        $numericCols = [];
        $stringCols = [];
        foreach ($columns as $h => $colData) {
            $nonEmptyCount = 0;
            $numericCount = 0;
            foreach ($colData as $cell) {
                if ($cell === null || $cell === '') continue;
                $nonEmptyCount++;
                if (is_numeric($cell)) $numericCount++;
            }
            // numeric if majority of non-empty are numeric (threshold can be tuned)
            if ($nonEmptyCount > 0 && $numericCount / $nonEmptyCount >= 0.6) {
                $numericCols[$h] = array_map(function($v){ return is_numeric($v) ? +$v : null; }, $colData);
            } else {
                $stringCols[$h] = $colData;
            }
        }

        // choose default labels: first non-numeric column, else row indices
        if (!empty($stringCols)) {
            $labels = array_values($stringCols)[0];
            $labelHeader = array_keys($stringCols)[0];
        } else {
            // fallback: 1..N
            $labels = range(1, $rowCount);
            $labelHeader = null;
        }

        // prepare preview (first 10 rows)
        $preview = array_slice($sheet, 0, 10);

        return view('sheet.visualize', [
            'headers' => $headers,
            'columns' => $columns,
            'numericCols' => $numericCols,
            'stringCols' => $stringCols,
            'labels' => $labels,
            'labelHeader' => $labelHeader,
            'preview' => $preview
        ]);
    }

    // helper: decide if a row is header-like (many non-numeric strings)
    private function rowLooksLikeHeader(array $row): bool
    {
        $strCount = 0;
        $numCount = 0;
        foreach ($row as $cell) {
            if ($cell === null) continue;
            $cell = (string)$cell;
            // treat as numeric if looks numeric after removing commas/currency
            $clean = preg_replace('/[,\s\$₹€£]/u', '', $cell);
            if ($clean === '') continue;
            if (is_numeric($clean)) $numCount++; else $strCount++;
        }
        // header if more strings than numbers
        return $strCount >= max(1, $numCount);
    }

    // helper: normalize cell values - trim, remove weird spaces, convert numeric-looking strings to plain numeric string
    private function cleanCellValue($val)
    {
        if ($val === null) return null;
        $v = trim((string)$val);

        if ($v === '') return '';

        // remove common currency separators (commas) but keep decimal dot
        $maybeNumeric = preg_replace('/[,\s₹$€£]/u', '', $v);

        // if looks numeric, return numeric string (we'll cast later)
        if (is_numeric($maybeNumeric)) {
            return $maybeNumeric;
        }

        return $v;
    }
}
