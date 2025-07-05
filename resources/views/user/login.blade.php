@extends('user.layouts.app')

@section('title', 'User Login - TGG Edge') 
@php
    $is_sidebar = false;
@endphp
@section('content')
<div class="container py-2 d-flex justify-content-center align-items-center my-2">
    <div class="card shadow rounded-4 p-4" style="max-width: 500px; width: 100%; background-color: #fff;">
        <h4 class="text-center mb-4">Login</h4>
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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{route('user.login')}}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn  w-100 mt-2 text-white" style="background-color: #033576; border-color: #033576;">Login</button>
            {{-- <p class="text-center mt-4 mb-1">Don't have an account? Register as:</p>
            <div class="text-center">
                <a href="{{ url('/user/register/1') }}" class="btn btn-sm btn-outline-primary m-1">RHM Club</a>
                <a href="{{ url('/user/register/2') }}" class="btn btn-sm btn-outline-success m-1">NCRH</a>
                <a href="{{ url('/user/register/3') }}" class="btn btn-sm btn-outline-secondary m-1">Freelance</a>
            </div> --}}

        </form>
    </div>
</div>
@endsection
