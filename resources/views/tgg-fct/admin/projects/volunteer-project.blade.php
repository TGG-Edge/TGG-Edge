@extends('tgg-fct.layouts.app')

@section('title', 'Volunteer Projects | Tgg Edge | Tgg Fct')

@section('content')
<div class="container-fluid py-4">

    <div class="row mt-4 admin-newapplication">
        <div class="col-12">
            <h2 class="admin-newappheading text-center text-md-start mb-4">VOLUNTEER PROJECTS</h2>
            @include('tgg-fct.layouts.includes.message')

            <div class="table-responsive">
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

            <hr class="my-4">

            <div class="d-flex justify-content-center">
                {{ $volunteerProjects->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
