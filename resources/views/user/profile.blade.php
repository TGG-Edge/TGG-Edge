@extends('user.layouts.app')

@section('title', 'Profile - TGG Edge')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-heading">USER PROFILE</h2>
    {{-- @if(Auth::check() && Auth::user()->user_role != 1) --}}

    <div>
        <span class="pagesub-heading">Account Status: </span>
            <span class="badge 
                @if($user->approval === 'accepted') bg-success 
                @elseif($user->approval === 'rejected') bg-danger 
                @else bg-warning text-dark @endif p-2 page-button">
                {{ ucfirst($user->approval) }}
        </span>
    </div>
    {{-- @endif --}}
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3 page-text">
                <label>Name:</label>
                <input type="text" name="name" class="form-control page-inputtext" value="{{ $user->name }}">
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>Email:</label>
                <input type="email" name="email" class="form-control page-inputtext" value="{{ $user->email }}" readonly>
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>Phone:</label>
                <input type="text" name="phone" class="form-control page-inputtext" value="{{ $user->phone }}">
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>Address:</label>
                <textarea name="address" class="form-control page-inputtext">{{ $user->address }}</textarea>
            </div>
           <!-- <div class="col-md-6 mb-3">
                <label>Document Type:</label>
                <select name="document_type" class="form-select" required>
                    <option disabled {{ is_null($user->document_type) ? 'selected' : '' }}>Select</option>
                    <option value="aadhar" {{ $user->document_type == 'aadhar' ? 'selected' : '' }}>Aadhar</option>
                    <option value="voter" {{ $user->document_type == 'voter' ? 'selected' : '' }}>Voter ID</option>
                    <option value="dl" {{ $user->document_type == 'dl' ? 'selected' : '' }}>Driving License</option>
                </select>
            </div> -->

            <!-- <div class="col-md-6 mb-3">
                <label>Document Number:</label>
                <input type="text" name="document_number" class="form-control" value="{{ $user->document_number }}">
            </div> -->
            <div class="col-md-6 mb-3 page-text">
                <label>RHM Number:</label>
                <input type="text" name="rhm_number" class="form-control page-inputtext" value="{{ $user->rhm_number }}">
            </div>
            @if($user->user_role == 2)
            <div class="col-md-6 mb-3 page-text">
                <label>Project:</label>
                <input type="text" name="project" class="form-control page-inputtext" value="{{ $user->project  ?? 'N/A' }}" readonly>

            </div>
            @endif
            <!-- <div class="col-md-6 mb-3">
                <label>Profile Image:</label>
                <input type="file" name="image" class="form-control">
                @if($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" class="img-thumbnail mt-2" width="100">
                @endif
            </div> -->
        </div>

        <hr>
        <h5 class="page-heading">CHANGE PASSWORD</h5>
        <div class="row">
            <div class="col-md-6 mb-3 page-text">
                <label>Current Password:</label>
                <input type="password" name="current_password" class="form-control page-inputtext">
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>New Password:</label>
                <input type="password" name="new_password" class="form-control page-inputtext">
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>Confirm New Password:</label>
                <input type="password" name="new_password_confirmation" class="form-control page-inputtext">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3 page-button">Update Profile</button>
    </form>
</div>
@endsection
