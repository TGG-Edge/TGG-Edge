@extends('tgg-india.layouts.app')
<!-- @include('tgg-india.layouts.includes.message') -->

@section('title', 'Profile - TGG Edge')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-heading">USER PROFILE</h2>

    @include('tgg-india.layouts.includes.message')
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

    <form action="{{ route('tgg-india.admin.profile.update') }}" method="POST" enctype="multipart/form-data">
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
           
            <div class="col-md-6 mb-3 page-text">
                <label>RHM Number:</label>
                <input type="text" name="rhm_number" class="form-control page-inputtext" value="{{ $user->rhm_number }}">
            </div>
          
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
