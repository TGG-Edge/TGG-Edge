@extends('tgg-india.layouts.app')
@section('title', 'User Login | TGG Meta | TGG India')
@php $is_sidebar = false; @endphp

@section('content')
<div class="container py-4">
    {{-- Top Description --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold">WELCOME TO TGG'S ECO-ENTREPRENEURSHIP DEVELOPMENT PROGRAM</h2>
        <p class="text-muted">Your gateway to purposeful collective action and transformative growth within the TGG Family. Anchored in the vision of TGG, this platform empowers advisors to explore eco entrepreneurship, cultivate investment habits, engage in regenerative travel, and build meaningful networks across borders. With a strong focus on revenue generation for passive income, alongside health and responsible investments, TGG-Meta offers structured learning, mentorship, and real-world application. It’s a living ecosystem where values meet action—enabling every advisor to evolve into a self-reliant changemaker contributing to a sustainable, inclusive future.</p>
    </div>

    {{-- Split Layout --}}
    <div class="row justify-content-center align-items-center">
        {{-- Left Image --}}
        <div class="col-md-7 d-none d-md-block text-center">
            <img src="{{ asset('assets/tgg-india/images/login-2.png') }}" alt="TGG Edge Login" class="img-fluid rounded-4 shadow loginimg" style="height: 500px">
        </div>

        {{-- Right Login Form --}}
        <div class="col-md-5 col-lg-5">
            <div class="card shadow rounded-4 p-4 loginbox" style="background-color: #fff; ">
                <h4 class="text-center mb-4 custom-heading">Login</h4>

                {{-- Flash Messages --}}
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

                {{-- Login Form --}}
                <form method="POST" action="{{ route('tgg-india.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    </div>
                    <div class="mb-3" style="position: relative;">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                        <span class="input-group-text toggle-pass" style="cursor:pointer;right: 0px;height: 32px;">👁</span>
                    </div>
                    <button type="submit" class="btn w-100 mt-2 text-white login-btn" style="background-color: #033576; border-color: #033576;">
                        Login
                    </button>
                </form>      
            </div>
        </div>
    </div>
</div>
@endsection
