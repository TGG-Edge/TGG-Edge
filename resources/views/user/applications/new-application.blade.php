@extends('user.layouts.app')

@section('title', 'User Dashboard - TGG Edge')

@section('content')
<div class="container-fluid">
    <div class="row mt-4 admin-newapplication">
        <div class="col-md-12">
            <h4 class="text-uppercase font-weight-bold admin-newappheading">New APPLICATIONS</h4>
            @include('user.layouts.includes.message')

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="admin-application-table">NAME</th>
                        <th class="admin-application-table">RHM REGISTRATION</th>
                        <th class="admin-application-table">ENGAGEMENT TYPE</th>
                        <th class="admin-application-table">PROFILE</th>
                        <th class="admin-application-table">APPROVAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newApplications as $app)
                    <tr>
                        <td>{{ $app->name }}</td>
                        <td>{{ $app->rhm_number }}</td>
                        <td>{{ $app->user_role == 2 ? 'Researcher' : 'Volunteer'; }}</td>
                        <td>
                            <a href="{{ route('user.user-profile',$app->id) }}">View/Edit</a>
                        </td>
                        <td>
                            <a href="{{ route('user.users.update.approval', [$app->id,'action' => 'accepted']) }}" class="text-success">Accept</a> /
                            <a href="{{ route('user.users.update.approval', [$app->id,'action' => 'rejected']) }}" class="text-danger">Reject</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="text-danger small">Note: Once the application is approved or rejected, it will go to the processed application section</p>
        </div>
        {{-- Pagination --}}
    <hr class="my-4">

    <div class="mt-4">
        {{ $newApplications->links() }}
    </div>
    </div>

</div>
@endsection
