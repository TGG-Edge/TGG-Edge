@extends('tgg-fct.layouts.app')

@section('title', 'User Profile - TGG Edge')

@section('content')
<div class="container">
    <h2 class="page-heading">User Registration Requests</h2>

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

    {{-- Show only pending users --}}
        <div class="card mb-4 p-3">
            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="page-text" ><label>Name:</label> {{ $user->name }}</div>
                    <div class="page-text"><label>Email:</label> {{ $user->email }}</div>
                    <div class="page-text"><label>Phone:</label> {{ $user->phone }}</div>
                    <div class="page-text"><label>Address:</label> {{ $user->address }}</div>
                    <div class="page-text"><label>RHM Number:</label> {{ $user->rhm_number }}</div>
                    <div class="page-text"><label>Research Assistance:</label> {{ $user->research_assistance ? 'Yes' : 'No' }}</div> --}}

                    <form action="{{ route('tgg-fct.admin.users.profile.update', $user->id) }}" method="POST">
                        @csrf

                        <div class="page-text">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="page-text">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="page-text">
                            <label>Phone:</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="page-text">
                            <label>Address:</label>
                            <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="page-text">
                            <label>RHM Number:</label>
                            <input type="text" name="rhm_number" class="form-control" value="{{ old('rhm_number', $user->rhm_number) }}">
                        </div>

                        <div class="page-text form-check">
                            <input type="checkbox" name="research_assistance" class="form-check-input" id="research_assistance"
                                value="1" {{ $user->research_assistance ? 'checked' : '' }}>
                            <label class="form-check-label" for="research_assistance">Research Assistance</label>
                        </div>


                        <div class="page-text mt-3">
                            <button type="submit" class="btn btn-primary page-button">Update User</button>
                        </div>
                    </form>


                    <hr>
                    <form method="POST" action="{{ route('tgg-fct.admin.users.update.project', $user->id) }}" class="my-2">
                        @csrf
                        <h5 class="page-heading"> Project:</h5>
                        <div class="d-flex justify-content-between">
                            <input type="text" name="project" value="{{ $user->project }}" class="form-control m-0" />
                            <button class="btn btn-sm btn-primary mx-2 page-button">Update</button>
                        </div>
                    </form>

                    <hr>
                    <h5 class="page-heading"> Approval Status: </h5>  

                    <div class="d-flex ">
                       <div class="d-flex gap-2">
                            <a href="{{ route('tgg-fct.admin.users.update.approval', [$user->id, 'action' => 'pending']) }}"
                            class="btn btn-warning text-white {{ $user->approval == 'pending' ? 'disabled' : '' }} page-button ">
                                Pending
                            </a>

                            <a href="{{ route('tgg-fct.admin.users.update.approval', [$user->id, 'action' => 'accepted']) }}"
                            class="btn btn-success text-white {{ $user->approval == 'accepted' ? 'disabled' : '' }} page-button">
                                Accept
                            </a>

                            <a href="{{ route('tgg-fct.admin.users.update.approval', [$user->id, 'action' => 'rejected']) }}"
                            class="btn btn-danger text-white {{ $user->approval == 'rejected' ? 'disabled' : '' }} page-button">
                                Reject
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
