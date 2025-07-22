@extends('user.layouts.app')

@section('title', 'Volunteer Projects - TGG Edge')

@section('content')
<div class="container-fluid">

    <div class="row mt-4">
        <div class="col-md-12 mt-5">
            <h4 class="text-uppercase font-weight-bold">Volunteer Projects</h4>
            @include('user.layouts.includes.message')

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Researcher Name</th>
                        <th>Project</th>
                        <th>Progress%</th>
                        <th>Evaluate Progress%</th>
                        <th>View the progress</th>
                        <th>Archive</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($volunteerProjects as $volunteerProject)
                    <tr>
                        <td>{{ $volunteerProject->volunteer->name }}</td>
                        <td>{{ $volunteerProject->project->researcher->name }}</td>
                        <td>{{ Str::limit($volunteerProject->project->title, 20) }}</td>
                        <td>{{ $volunteerProject->progress_percentage ?? '0'}}%</td>
                        <td>{{ $volunteerProject->researcher_progress_percentage	?? '0' }}%</td>
                       <td>
                            @if($volunteerProject->document_url)
                                <a href="{{ $volunteerProject->document_url }}" target="_blank">Google word file link shared by Researcher</a>
                            @else
                                N/A
                            @endif
                        </td>

                        <td><a href="{{ route('user.volunteer-project.freezed', $volunteerProject->id) }}" class="btn btn-sm btn-danger {{ $volunteerProject->status == 'freezed' ? 'disabled' : '' }}">freezed</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <p class="text-danger small">Note: This will list all the projects in progress, once a project is complete, we have to shift it to an XL sheet and remove it from here</p> --}}
        </div>
        <hr class="my-4">

    <div class="mt-4">
        {{ $volunteerProjects->links() }}
    </div>
    </div>
</div>
@endsection
