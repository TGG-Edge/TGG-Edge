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
        <div class="card mb-3 p-3">
            <strong>Name:</strong> {{ $user->name }} <br>
            <strong>Email:</strong> {{ $user->email }} <br>
            <form method="POST" action="{{ route('user.users.update.project', $user->id) }}" class="my-2">
                @csrf
                <label>Project:</label>
                <input type="text" name="project" value="{{ $user->project }}" class="form-control mb-2" />
                <button class="btn btn-sm btn-primary">Update Project</button>
            </form>
            <form method="POST" action="{{ route('user.users.update.approval', $user->id) }}">
                @csrf
                <label>Approval Status:</label>
                <select name="approval" class="form-select mb-2">
                    <option value="pending" {{ $user->approval == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ $user->approval == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ $user->approval == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button class="btn btn-sm btn-success">Save</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
