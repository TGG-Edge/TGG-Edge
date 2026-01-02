@extends('tgg-india.layouts.app')

@section('title', 'Create Campaign')

@section('content')
    <div class="admin-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="trainer-heading">Create Campaign</h4>
            <a href="{{ asset('assets/excels/email-campaign-template.xlsx') }}" class="btn btn-sm btn-outline-success mt-2">
                <i class="fas fa-file-excel me-1"></i> Download Sample Excel
            </a>
        </div>

        @include('tgg-india.layouts.includes.message')

        <div class="card p-3">

            <form method="POST" action="{{ route('tgg-india.campaigns.store', [request()->route('role')]) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Select Template</label>
                        <select name="template_id" class="form-control" required>
                            <option value="">-- Select --</option>
                            @foreach ($templates as $template)
                                <option value="{{ $template->id }}">
                                    {{ $template->name }} ({{ $template->type }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Upload Excel</label>
                        <input type="file" name="excel_file" class="form-control" required>
                        <small class="text-muted">Excel must contain email, name, etc.</small>

                    </div>

                </div>

                <button class="btn btn-primary mt-3">
                    <i class="fas fa-paper-plane"></i> Start Campaign
                </button>

            </form>
        </div>
    </div>
@endsection
