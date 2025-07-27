@extends('user.layouts.app')

@section('title', 'Volunteer Projects - TGG Edge')

@section('content')
<div class="container-fluid">

    <div class="row mt-4">
        <div class="col-md-12 mt-5" admin-newapplication>
            <h2 class="admin-newappheading">VOLUNTEER PROJRCTS</h4>
            @include('user.layouts.includes.message')

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="admin-application-table">NAME</th>
                        <th class="admin-application-table">RESEACHER NAME</th>
                        <th class="admin-application-table">PROJRCT</th>
                        <th class="admin-application-table">PROGRESS%</th>
                        <th class="admin-application-table">EVALUATE THE PROGRESS%</th>
                        <th class="admin-application-table">VIEW THE PROGRESS</th>
                        <th class="admin-application-table">ARCHIVE</th>
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
                                <a href="{{ $volunteerProject->document_url }}" target="_blank">Worksheet by researcher</a>
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                        <a href="{{ route('user.volunteer-project.freezed', $volunteerProject->id) }}"
                        class="btn btn-sm {{ $volunteerProject->status == 'freezed' ? 'btn-dark' : 'btn-danger' }}">
                        {{ $volunteerProject->status == 'freezed' ? 'Freezed' : 'Freeze' }}
                        </a>
                        </td>
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
