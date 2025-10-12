@extends('tgg-india.layouts.app')

@section('title', 'Processed Application | TGG Meta | TGG India')

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12 admin-newapplication">
            <h4 class="text-uppercase font-weight-bold admin-newappheading">PROCESSED APPLICATIONS</h4>
            @include('tgg-india.layouts.includes.message')

            <div class="table-responsive" style="max-height: 65vh; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 8px;">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="thead-dark sticky-top bg-light" style="z-index: 2;">
                        <tr>
                            <th class="admin-application-table text-center" style="font-weight: 600;">NAME</th>
                            <th class="admin-application-table text-center" style="font-weight: 600;">RHM REGISTRATION</th>
                            <th class="admin-application-table text-center" style="font-weight: 600;">ENGAGEMENT TYPE</th>
                            <th class="admin-application-table text-center" style="font-weight: 600;">PROFILE</th>
                            <th class="admin-application-table text-center" style="font-weight: 600;">APPROVAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($processedApplications as $app)
                            <tr>
                                <td>{{ $app->name }}</td>
                                <td>{{ $app->rhm_number }}</td>
                                <td>{{ $app->role_name }}</td>
                                <td>
                                    <a href="{{ route('tgg-india.admin.user-profile',$app->id) }}">View/Edit</a>
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
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No processed applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <p class="text-danger small mt-3">
                Note: A rejected application can be approved by you if required by editing the profile and approval, so click on View/Edit.
            </p>

            <hr class="my-4">
            <div class="mt-3 d-flex justify-content-center">
                {{ $processedApplications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
