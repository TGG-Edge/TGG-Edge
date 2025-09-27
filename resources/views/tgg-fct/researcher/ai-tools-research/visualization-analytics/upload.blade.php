@extends('tgg-fct.layouts.app')
@section('title', 'Upload | Data Visualization | AI Tools & Research Systems | Tgg Edge | Tgg Fct')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="page-header">
            <h3 class=" knowledge">
               <i class="fas fa-chart-line me-2 text-primary"></i> Upload Excel/CSV for Visualization & Analytics
            </h3>
            <p style=" color: #555; font-size: 10px;">
                Easily upload your research datasets and generate visual insights.
            </p>
        </div>


        <!-- Iframe Container -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('tgg-fct.researcher.ai-tools-research.visualization-analytics.upload') }}"
                    method="POST" enctype="multipart/form-data" class="text-center p-3">
                    @csrf

                    <!-- File Input -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Choose File</label>
                        <input type="file" name="file" accept=".csv,.xls,.xlsx" class="form-control w-50 mx-auto"
                            required>
                        <small class="text-muted d-block mt-1">
                            Accepted formats: .csv, .xls, .xlsx
                        </small>
                    </div>

                    <!-- Upload Button -->
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-cloud-upload-alt me-1"></i> Upload & Visualize
                    </button>
                </form>
            </div>
        </div>


    </div>
@endsection
