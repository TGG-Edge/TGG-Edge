@extends('tgg-india.layouts.app')

@section('title', 'Check Emails')

@section('content')
<div class="admin-container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="trainer-heading">Check Emails (DISIFY)</h4>

        <a href="{{ asset('assets/excels/email-campaign-template.xlsx') }}"
           class="btn btn-sm btn-outline-success">
            <i class="fas fa-file-excel me-1"></i> Download Sample Excel
        </a>
    </div>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-3">
        <form method="POST"
              action="{{ route('tgg-india.email-check.store', request()->route('role')) }}"
              enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Upload Excel</label>
                    <input type="file" name="excel_file" class="form-control" required>
                    <small class="text-muted">
                        Excel must contain <b>name</b> & <b>email</b> columns
                    </small>
                </div>
            </div>

            <button class="btn btn-primary mt-3">
                <i class="fas fa-search"></i> Check Emails
            </button>
        </form>
    </div>

</div>
@endsection
