@extends('user.layouts.app')

@section('title', 'Reseacher Projects - TGG Edge')

@section('content')
<div class="container-fluid">

    <div class="row mt-4">
        <div class="col-md-12">
            <h4 class="text-uppercase font-weight-bold">Research Projects</h4>
            @include('user.layouts.includes.message')

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Project</th>
                        <th>Progress%</th>
                        <th>View the progress</th>
                        <th>Freezed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($researchProjects as $project)
                    <tr>
                        <td>{{ $project->researcher->name  }}</td>
                        <td>{{ Str::limit($project->title, 20) }}</td>
                        <td>{{ $project->progress_percentage ?? 'N/A' }}%</td>
                        <td>
                            @if($project->document_url)
                                <a href="{{ $project->document_url }}" target="_blank">Google word file link shared by Researcher</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                           <a href="{{ route('user.researcher-project.freezed', $project->id) }}"
                            class="btn btn-sm {{ $project->status == 'freezed' ? 'btn-dark' : 'btn-danger' }}">
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
