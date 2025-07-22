@extends('user.layouts.app')

@section('title', 'User Dashboard - TGG Edge')

@section('content')
<div class="container-fluid">

    <div class="row mt-4">
        <div class="col-md-12 mt-5">
            <h4 class="text-uppercase font-weight-bold">Processed Application</h4>
            @include('user.layouts.includes.message')

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>RHM Registration</th>
                        <th>Engagement Type</th>
                        <th>Profile</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($processedApplications as $app)
                    <tr>
                        <td>{{ $app->name }}</td>
                        <td>{{ $app->rhm_number }}</td>
                        <td>{{  $app->user_role == 2 ? 'Researcher' : 'Volunteer'; }}</td>
                        <td>
                             <a href="{{ route('user.user-profile',$app->id) }}">View/Edit</a>
                        </td>
                        <td>
                            @if($app->approval == 'accepted')
                                <span class="text-success">Accepted</span>
                            @elseif($app->approval == 'rejected')
                                <span class="text-danger">Rejected</span>
                            @else
                                <span class="text-warning">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="text-danger small">Note: A rejected application can be approved by the you if required  editing the profile and approval so click on view/edit.</p>
        </div>
        <hr class="my-4">

    <div class="mt-4">
        {{ $processedApplications->links() }}
    </div>
    </div>

</div>
@endsection
