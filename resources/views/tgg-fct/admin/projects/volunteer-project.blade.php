@extends('tgg-fct.layouts.app')

@section('title', 'Volunteer Projects | Tgg Edge | Tgg Fct')

@section('content')
<div class="container-fluid py-4">

    <div class="row mt-4 admin-newapplication">
        <div class="col-12">
            <h2 class="admin-newappheading text-center text-md-start mb-4">VOLUNTEER PROJECTS</h2>
            @include('tgg-fct.layouts.includes.message')

            <!-- Desktop Table (hidden on mobile/tablet) -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="font-weight: 500;">NAME</th>
                            <th style="font-weight: 500;">RESEARCHER NAME</th>
                            <th style="font-weight: 500;">PROJECT</th>
                            <th style="font-weight: 500;">PROGRESS%</th>
                            <th style="font-weight: 500;">EVALUATE%</th>
                            <th style="font-weight: 500;">VIEW THE PROGRESS</th>
                            <th style="font-weight: 500;">ARCHIVE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($volunteerProjects as $volunteerProject)
                        <tr>
                            <td>{{ $volunteerProject->volunteer->name }}</td>
                            <td>{{ $volunteerProject->project->researcher->name }}</td>
                            <td>{{ Str::limit($volunteerProject->project->title, 20) }}</td>
                            <td>{{ $volunteerProject->progress_percentage ?? '0' }}%</td>
                            <td>{{ $volunteerProject->researcher_progress_percentage ?? '0' }}%</td>
                            <td>
                                @if($volunteerProject->document_url)
                                    <a href="{{ $volunteerProject->document_url }}" target="_blank" class="text-decoration-none">Worksheet by volunteer</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('tgg-fct,admin.volunteer-project.freezed', $volunteerProject->id) }}"
                                   class="btn btn-sm {{ $volunteerProject->status == 'freezed' ? 'btn-dark' : 'btn-danger' }} w-100 w-md-auto text-nowrap">
                                    {{ $volunteerProject->status == 'freezed' ? 'Freezed' : 'Freeze' }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile/Tablet Card View (hidden on desktop) -->
            <div class="d-lg-none">
                @foreach($volunteerProjects as $volunteerProject)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">{{ $volunteerProject->volunteer->name }}</h5>
                        <p class="text-muted small mb-3">Researcher: {{ $volunteerProject->project->researcher->name }}</p>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-12">
                                <span class="text-muted small">PROJECT:</span>
                                <p class="mb-0">{{ Str::limit($volunteerProject->project->title, 50) }}</p>
                            </div>
                            
                            <div class="col-6">
                                <span class="text-muted small">PROGRESS:</span>
                                <p class="mb-0 fw-semibold">{{ $volunteerProject->progress_percentage ?? '0' }}%</p>
                            </div>
                            
                            <div class="col-6">
                                <span class="text-muted small">EVALUATE:</span>
                                <p class="mb-0 fw-semibold">{{ $volunteerProject->researcher_progress_percentage ?? '0' }}%</p>
                            </div>
                            
                            <div class="col-12 mt-2">
                                <span class="text-muted small">WORKSHEET:</span>
                                @if($volunteerProject->document_url)
                                    <p class="mb-0">
                                        <a href="{{ $volunteerProject->document_url }}" target="_blank" class="text-decoration-none">View worksheet →</a>
                                    </p>
                                @else
                                    <p class="mb-0 text-muted">N/A</p>
                                @endif
                            </div>
                            
                            <div class="col-12 mt-2">
                                <span class="text-muted small">STATUS:</span>
                                <p class="mb-0">
                                    <span class="badge {{ $volunteerProject->status == 'freezed' ? 'bg-dark' : 'bg-success' }}">
                                        {{ $volunteerProject->status == 'freezed' ? 'Freezed' : 'Active' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <a href="{{ route('tgg-fct,admin.volunteer-project.freezed', $volunteerProject->id) }}"
                           class="btn btn-sm {{ $volunteerProject->status == 'freezed' ? 'btn-dark' : 'btn-danger' }} w-100">
                            {{ $volunteerProject->status == 'freezed' ? 'Freezed' : 'Freeze Project' }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-center">
                {{ $volunteerProjects->links() }}
            </div>
        </div>
    </div>
</div>
@endsection