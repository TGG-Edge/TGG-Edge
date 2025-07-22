@extends('user.layouts.app')

@section('title', 'User Profile - TGG Edge')

@section('content')
<div class="container mt-4">
    <h3>User Registration Requests</h3>

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
                    <div><strong>Name:</strong> {{ $user->name }}</div>
                    <div><strong>Email:</strong> {{ $user->email }}</div>
                    <div><strong>Phone:</strong> {{ $user->phone }}</div>
                    <div><strong>Address:</strong> {{ $user->address }}</div>
                    <div><strong>RHM Number:</strong> {{ $user->rhm_number }}</div>
                    <div><strong>Research Assistance:</strong> {{ $user->research_assistance ? 'Yes' : 'No' }}</div>

                    <form method="POST" action="{{ route('user.users.update.project', $user->id) }}" class="my-2">
                        @csrf
                        <label><strong>Project:</strong></label>
                        <div class="d-flex justify-content-between">
                            <input type="text" name="project" value="{{ $user->project }}" class="form-control m-0" />
                            <button class="btn btn-sm btn-primary mx-2">Update</button>
                        </div>
                    </form>

                    <label><strong>Approval Status:</strong></label>    

                    <div class="d-flex ">
                       <div class="d-flex gap-2">
                            <a href="{{ route('user.users.update.approval', [$user->id, 'action' => 'pending']) }}"
                            class="btn btn-warning text-white {{ $user->approval == 'pending' ? 'disabled' : '' }}">
                                Pending
                            </a>

                            <a href="{{ route('user.users.update.approval', [$user->id, 'action' => 'accepted']) }}"
                            class="btn btn-success text-white {{ $user->approval == 'accepted' ? 'disabled' : '' }}">
                                Accept
                            </a>

                            <a href="{{ route('user.users.update.approval', [$user->id, 'action' => 'rejected']) }}"
                            class="btn btn-danger text-white {{ $user->approval == 'rejected' ? 'disabled' : '' }}">
                                Reject
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
