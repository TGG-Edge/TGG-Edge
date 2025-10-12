@extends('tgg-india.layouts.app')

@section('title', 'New Application | TGG Meta | TGG India')

@section('content')
<div class="container-fluid">
    <div class="row mt-4 admin-newapplication">
        <div class="col-md-12">
            <h2 class="admin-newappheading">NEW APPLICATIONS</h2>
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
                        @forelse($newApplications as $app)
                            <tr>
                                <td>{{ $app->name }}</td>
                                <td>{{ $app->rhm_number }}</td>
                                <td>{{ $app->role_name }}</td>
                                <td>
                                    <a href="{{ route('tgg-india.admin.user-profile', $app->id) }}">View/Edit</a>
                                </td>
                                <td>
                                    <a href="{{ route('tgg-india.admin.users.update.approval', [$app->id,'action' => 'accepted']) }}" class="text-success fw-bold">Accept</a> /
                                    <a href="{{ route('tgg-india.admin.users.update.approval', [$app->id,'action' => 'rejected']) }}" class="text-danger fw-bold">Reject</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No new applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <p class="text-danger small mt-3">
                <strong>Note:</strong> Once the application is approved or rejected, it will move to the processed application section.
            </p>

            {{-- Pagination --}}
            <hr class="my-4">
            <div class="mt-3 d-flex justify-content-center">
                {{ $newApplications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
