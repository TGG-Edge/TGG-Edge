@extends('tgg-fct.layouts.app')

@section('title', 'Reseacher Projects - TGG Edge')

@section('content')
<div class="container-fluid">

    <div class="row mt-4 admin-newapplication">
        <div class="col-md-12">
            <h2 class="admin-newappheading">RESEARCH PROJECTS</h4>
            @include('tgg-fct.layouts.includes.message')

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="admin-application-table" style="font-weight: 500;  background: lightgray;">NAME</th>
                        <th class="admin-application-table" style="    font-weight: 500;  background: lightgray;">PROJECT</th>
                        <th class="admin-application-table" style="    font-weight: 500;  background: lightgray;">PROGRESS%</th>
                        <th class="admin-application-table" style="    font-weight: 500;  background: lightgray;">VIEW THE PROGRESS</th>
                        <th class="admin-application-table" style="    font-weight: 500;  background: lightgray;">FREEZED</th>
                    </tr>
                </thead>
                <tbody class="admin-projects-table">
                    @foreach($researchProjects as $project)
                    <tr>
                        <td>{{ $project->researcher->name  }}</td>
                        <td>{{ Str::limit($project->title, 20) }}</td>
                        <td>{{ $project->progress_percentage ?? 'N/A' }}%</td>
                        <td>
                            @if($project->document_url)
                                <a href="{{ $project->document_url }}" target="_blank">Worksheet by researcher</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                           <a href="{{ route('tgg-fct.admin.researcher-project.freezed', $project->id) }}"
                            class="btn btn-sm {{ $project->status == 'freezed' ? 'btn-dark' : 'btn-danger' }} btn-tight">
                            {{ $project->status == 'freezed' ? 'Freezed' : 'Freeze' }}
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <p class="text-danger small">Note: This will list all the projects in progress, once a project is complete we have to shift it to an XL sheet and remove it from here</p> --}}
        </div>

       
        <hr class="my-4">

    <div class="mt-4">
        {{ $researchProjects->links() }}
    </div>
    </div>
</div>
@endsection
