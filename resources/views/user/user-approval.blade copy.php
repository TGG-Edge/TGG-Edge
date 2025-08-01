@extends('user.layouts.app')

@section('title', 'User Requests')

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

    @foreach($users as $user)
        <div class="card mb-4 p-3">
            <div class="row">
                <div class="col-md-2 text-center">
                    <img src="{{ asset('storage/' . $user->image) }}" alt="User Image" class="img-thumbnail rounded" style="width:100px; height:100px; object-fit:cover;">
                </div>
                <div class="col-md-10">
                    <span><strong>Name:</strong> {{ $user->name }}</span>
                    <span><strong> | Email:</strong> {{ $user->email }}</span>
                    <span><strong> | Phone:</strong> {{ $user->phone }}</span>
                    <span><strong> | Address:</strong> {{ $user->address }}</span>
                    <span><strong> | RHM Number:</strong> {{ $user->rhm_number }}</span>
                    <span><strong> |Research Assistance:</strong> {{ $user->research_assistance ? 'Yes' : 'No' }}</span>

                    <form method="POST" action="{{ route('user.users.update.project', $user->id) }}" class="my-2">
                        @csrf
                        <label><strong>Project:</strong></label>
                        <div class="d-flex justify-content-between">
                            <input type="text" name="project" value="{{ $user->project }}" class="form-control m-0" />
                            <button class="btn btn-sm btn-primary mx-2 ">Update</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('user.users.update.approval', $user->id) }}">
                        @csrf
                        <label><strong>Approval Status:</strong></label>
                        <div class="d-flex justify-content-between">
                        <select name="approval" class="form-select">
                            <option value="pending" {{ $user->approval == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ $user->approval == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ $user->approval == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button class="btn btn-sm btn-success mx-2">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Pagination -->
    <div class="">
        {{ $users->links() }}
    </div>
</div>
@endsection
