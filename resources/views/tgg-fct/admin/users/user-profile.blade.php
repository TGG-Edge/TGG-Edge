@extends('tgg-fct.layouts.app')

@section('title', 'User Profile | Tgg Edge | Tgg Fct')

@section('content')
<div class="container py-4">

    <h2 class="page-heading text-center text-md-start mb-4">User Registration Requests</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4 p-3">
        <div class="row">
            <div class="col-12">

                <form action="{{ route('tgg-fct.admin.users.profile.update', $user->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone:</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label>Address:</label>
                        <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>RHM Number:</label>
                        <input type="text" name="rhm_number" class="form-control" value="{{ old('rhm_number', $user->rhm_number) }}">
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="research_assistance" class="form-check-input"
                                   id="research_assistance" value="1" {{ $user->research_assistance ? 'checked' : '' }}>
                            <label class="form-check-label" for="research_assistance">Research Assistance</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" name="is_link_enabled" class="form-check-input" id="is_link_enabled"
                                   value="1" {{ $user->is_link_enabled ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_link_enabled">Link (Sitemap)</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary page-button w-100 w-md-auto">Update User</button>
                    </div>
                </form>

                <hr>

                <form method="POST" action="{{ route('tgg-fct.admin.users.update.project', $user->id) }}" class="my-3">
                    @csrf
                    <h5 class="page-heading"> Project:</h5>
                    <div class="d-flex flex-column flex-md-row gap-2">
                        <input type="text" name="project" value="{{ $user->project }}" class="form-control">
                        <button class="btn btn-sm btn-primary page-button w-100 w-md-auto">Update</button>
                    </div>
                </form>

                <hr>

                <h5 class="page-heading mb-2"> Approval Status: </h5>
                <div class="d-flex flex-column flex-md-row gap-2">
                    <a href="{{ route('tgg-fct.admin.users.update.approval', [$user->id, 'action' => 'pending']) }}"
                       class="btn btn-warning text-white {{ $user->approval == 'pending' ? 'disabled' : '' }} page-button w-100 w-md-auto">
                        Pending
                    </a>

                    <a href="{{ route('tgg-fct.admin.users.update.approval', [$user->id, 'action' => 'accepted']) }}"
                       class="btn btn-success text-white {{ $user->approval == 'accepted' ? 'disabled' : '' }} page-button w-100 w-md-auto">
                        Accept
                    </a>

                    <a href="{{ route('tgg-fct.admin.users.update.approval', [$user->id, 'action' => 'rejected']) }}"
                       class="btn btn-danger text-white {{ $user->approval == 'rejected' ? 'disabled' : '' }} page-button w-100 w-md-auto">
                        Reject
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
