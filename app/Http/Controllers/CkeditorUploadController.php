<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CkeditorUploadController extends Controller
{
    public function store(Request $request)
    {
        // CKEditor may send file as "upload" or "file"
        $file = $request->file('upload') ?? $request->file('file');

        if (!$file) {
            return response()->json([
                'uploaded' => false,
                'error' => ['message' => 'No file received.']
            ], 422);
        }

        // Validate image
        $request->validate([
            'upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'file'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

        // Save inside public/uploads/ckeditor
        $file->move(public_path('uploads/ckeditor'), $filename);

        $url = asset('uploads/ckeditor/' . $filename);

        // Response for CKEditor
        return response()->json([
            'url' => $url,
            'uploaded' => true,
            'fileName' => $filename,
        ]);
    }
}
