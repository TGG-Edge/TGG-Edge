@extends('tgg-fct.layouts.app')

@section('title', 'Reseacher Projects | Tgg Edge | Tgg Fct')

@section('content')
<div class="container-fluid py-4">
    <div class="row mt-4 admin-newapplication">
        <div class="col-12">
            <h2 class="admin-newappheading text-center text-md-start mb-4">RESEARCH PROJECTS</h2>
            @include('tgg-fct.layouts.includes.message')

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="font-weight: 500;">NAME</th>
                            <th style="font-weight: 500;">PROJECT</th>
                            <th style="font-weight: 500;">PROGRESS%</th>
                            <th style="font-weight: 500;">VIEW THE PROGRESS</th>
                            <th style="font-weight: 500;">FREEZED</th>
                        </tr>
                    </thead>
                    <tbody class="admin-projects-table">
                        @foreach($researchProjects as $project)
                        <tr>
                            <td>{{ $project->researcher->name }}</td>
                            <td>{{ Str::limit($project->title, 20) }}</td>
                            <td>{{ $project->progress_percentage ?? 'N/A' }}%</td>
                            <td>
                                @if($project->document_url)
                                    <a href="{{ $project->document_url }}" target="_blank" class="text-decoration-none">Worksheet by researcher</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('tgg-fct.admin.researcher-project.freezed', $project->id) }}"
                                   class="btn btn-sm {{ $project->status == 'freezed' ? 'btn-dark' : 'btn-danger' }} btn-tight w-100 w-md-auto text-nowrap">
                                    {{ $project->status == 'freezed' ? 'Freezed' : 'Freeze' }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-center">
                {{ $researchProjects->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
