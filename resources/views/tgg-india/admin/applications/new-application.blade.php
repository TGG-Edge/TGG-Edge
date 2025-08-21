@extends('tgg-india.layouts.app')

@section('title', 'New Application | TGG Meta | TGG India')

@section('content')
<div class="container-fluid">
    <div class="row mt-4 admin-newapplication">
        <div class="col-md-12">
            <h2 class="admin-newappheading">NEW APPLICATIONS</h4>
            @include('tgg-india.layouts.includes.message')

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="admin-application-table" style="    font-weight: 500;  background: lightgray;">NAME</th>
                        <th class="admin-application-table" style="    font-weight: 500;  background: lightgray;">RHM REGISTRATION</th>
                        <th class="admin-application-table" style="    font-weight: 500;  background: lightgray;">ENGAGEMENT TYPE</th>
                        <th class="admin-application-table" style="    font-weight: 500;  background: lightgray;">PROFILE</th>
                        <th class="admin-application-table" style="    font-weight: 500;  background: lightgray;">APPROVAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newApplications as $app)
                    <tr>
                        <td>{{ $app->name }}</td>
                        <td>{{ $app->rhm_number }}</td>
                        <td>{{ $app->role_name }}</td>
                        <td>
                            <a href="{{ route('tgg-india.admin.user-profile',$app->id) }}">View/Edit</a>
                        </td>
                        <td>
                            <a href="{{ route('tgg-india.admin.users.update.approval', [$app->id,'action' => 'accepted']) }}" class="text-success">Accept</a> /
                            <a href="{{ route('tgg-india.admin.users.update.approval', [$app->id,'action' => 'rejected']) }}" class="text-danger">Reject</a>
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
